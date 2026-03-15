<?php
namespace App\Controllers;

use App\Models\StaffModel;
use App\Models\ActivityModel;

class StaffController extends Controller {

    public function profile() {
        $user = $this->checkAuth();
        if (!$user) {
            $this->redirect('/login');
        }

        $staffModel = new StaffModel();
        $profile = $staffModel->getProfile($user['id']);

        return $this->view('dashboard/pages/staff_profile', [
            'title'   => 'Staff Profile | NAPS',
            'profile' => $profile
        ]);
    }
    public function updateProfile() {
        $user = $this->checkAuth();
        if (!$user) {
            return $this->json(['status' => 'error', 'message' => 'Session expired. Please login.'], 401);
        }
        $full_name   = $this->input('full_name');
        $phone       = $this->input('phone');
        $department  = $this->input('department');
        if (!$full_name) {
            return $this->json(['status' => 'error', 'message' => 'Full name is required'], 400);
        }

        $staffModel = new StaffModel();
        
        $data = [
            'full_name'   => $full_name,
            'phone'       => $phone,
            'department'  => $department,
        ];
        $success = $staffModel->upsert('staff_profiles', array_merge($data, ['user_id' => $user['id']]), 'user_id');

        if ($success) {
            $activity = new ActivityModel();
            $activity->log($user['id'], "Updated staff profile details");

            return $this->json([
                'status'  => 'success', 
                'message' => 'Profile updated successfully!'
            ]);
        }

        return $this->json(['status' => 'error', 'message' => 'Failed to update profile'], 500);
    }
}