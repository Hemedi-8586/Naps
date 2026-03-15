<?php
namespace App\Controllers;

use App\Models\CitizenModel;
use App\Models\PaymentModel;
use App\Models\Model;
use App\Models\NotificationModel;
use App\Models\ActivityModel; 

class CitizenController extends Controller {

    public function profile() {
        $user = $this->checkAuth();
        if (!$user) return $this->redirect('/login');
        $model = new CitizenModel();
        return $this->view('/dashboard/pages/profile', ['profile' => $model->getProfile($user['id'])]);
    }

    public function updateProfile() {
        $user = $this->checkAuth();
        if (!$user) return $this->json(['status' => 'error', 'message' => 'Unauthorized']);

        $model = new Model();
        $activity = new ActivityModel();

        $fullName = $this->input('full_name');
        $phone = $this->input('phone');
        $newPassword = $this->input('password');

        if (empty($fullName) || empty($phone)) {
            return $this->json(['status' => 'error', 'message' => 'Full name and Phone are required']);
        }

        $profileData = [
            'full_name' => $fullName,
            'phone'     => $phone,
        ];

        $existingProfile = $model->findWhere('citizen_profiles', ['user_id' => $user['id']]);
        
        if ($existingProfile) {
            $model->updateWhere('citizen_profiles', $profileData, ['user_id' => $user['id']]);
        } else {
            $profileData['user_id'] = $user['id'];
            $model->create('citizen_profiles', $profileData);
        }

        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $model->updateWhere('users', ['password' => $hashedPassword], ['id' => $user['id']]);
            $activity->log($user['id'], "Updated profile and changed password");
        } else {
            $activity->log($user['id'], "Updated profile information");
        }

        return $this->json(['status' => 'success', 'message' => 'Profile updated successfully!']);
    }

    public function allApplications() {
        $user = $this->checkAuth();
        $model = new Model();
        $permits = $model->where('permits', ['applicant_id' => $user['id']]);
        return $this->view('/dashboard/pages/applications_history', ['permits' => $permits]);
    }

    public function applications() {
        $user = $this->checkAuth();
        $model = new Model();
        $pending = $model->where('permits', ['applicant_id' => $user['id'], 'status' => 'Pending']);
        return $this->view('/dashboard/pages/apply', ['permits' => $pending]);
    }

    public function submitPermit() {
        $user = $this->checkAuth();
        $model = new Model();
        $notif = new NotificationModel();
        $activity = new ActivityModel(); 

        $fullName = $user['full_name'] ?? $this->getUserFullName($user['id']);
        $permitType = $this->input('permit_type');

        $permitData = [
            'applicant_id' => $user['id'],
            'permit_type'  => $permitType,
            'status'       => 'Pending',
            'created_at'   => date('Y-m-d H:i:s')
        ];
        
        $applicationId = $model->create('permits', $permitData);

        if ($applicationId) {
            $paymentData = [
                'user_id'        => $user['id'],
                'application_id' => $applicationId,
                'bill_number'    => 'BN-' . strtoupper(substr(md5(time()), 0, 8)), 
                'amount'         => 50000,          
                'currency'       => 'Tsh',
                'payment_type'   => 'Government Fee', 
                'status'         => 'Waiting for Payment',
                'created_at'     => date('Y-m-d H:i:s')
            ];
            $model->create('payments', $paymentData);

            $notif->send($user['id'], "Hello $fullName, your application for $permitType has been received.");
            $activity->log($user['id'], "Submitted a new permit application: $permitType");

            return $this->json(['status' => 'success', 'message' => 'Application submitted successfully!']);
        }
        return $this->json(['status' => 'error', 'message' => 'Failed to submit application.']);
    }
  
    public function payments() {
        $user = $this->checkAuth();
        $payModel = new PaymentModel();
        return $this->view('dashboard/pages/payments', [
            'payments' => $payModel->getUserPayments($user['id'])
        ]);
    }

    public function requestControlNo() {
        $user = $this->checkAuth();
        $id = $this->input('id');
        $payModel = new PaymentModel();
        $notif = new NotificationModel();
        $activity = new ActivityModel(); 
        
        $fullName = $user['full_name'] ?? $this->getUserFullName($user['id']);
        $controlNo = "99" . rand(100000000, 999999999);

        if($payModel->updateControlNumber($id, $controlNo)) {
            $notif->send($user['id'], "Hello $fullName, your Control Number ($controlNo) is now ready.");
            $activity->log($user['id'], "Requested Control Number for payment ID: $id");
            return $this->json(['status' => 'success', 'control_number' => $controlNo]);
        }
        return $this->json(['status' => 'error', 'message' => 'Failed to generate control number.']);
    }

    public function processPayment() {
        $user = $this->checkAuth();
        $id = $this->input('id');
        $payModel = new PaymentModel();
        $notif = new NotificationModel();
        $activity = new ActivityModel();

        $fullName = $user['full_name'] ?? $this->getUserFullName($user['id']);

        if($payModel->completePayment($id)) {
            $notif->send($user['id'], "Success! Hello $fullName, payment received.");
            $activity->log($user['id'], "Completed payment for bill ID: $id");
            return $this->json(['status' => 'success']);
        }
        return $this->json(['status' => 'error', 'message' => 'Payment failed.']);
    }

    private function getUserFullName($userId) {
        if (!$userId) return 'Citizen';
        $model = new Model();
        $userData = $model->where('users', ['id' => $userId]);
        if (!empty($userData) && isset($userData[0]['full_name'])) {
            return $userData[0]['full_name'];
        }
        return 'Citizen'; 
    }
}