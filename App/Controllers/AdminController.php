<?php
namespace App\Controllers;
use App\Models\Model;
use App\Models\UserModel;
use Config\Database;
use App\Models\PermissionModel;
use App\Models\StaffModel;
class AdminController extends Controller {
    
   public function users() {
    $userModel = new UserModel();
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 3;
    $offset = ($page - 1) * $limit;
    $totalUsers = $userModel->count('users') ?? 0; 
    $totalPages = ceil($totalUsers / $limit);
    $users = $userModel->getUsersWithProfiles($limit, $offset);
    
    return $this->view('users', [
        'title'       => 'NAPS | User Management',
        'users'       => $users,
        'currentPage' => $page,
        'totalPages'  => $totalPages
    ]);
}
    public function createUser() {
    $this->checkAuth();
    
    $userModel = new UserModel();
    $db = Database::getConnection();

    try {
        $db->beginTransaction();
        $stmt = $db->prepare("SELECT id FROM roles WHERE name = ?");
        $stmt->execute([$this->input('role_name')]);
        $role_id = $stmt->fetchColumn();

        if (!$role_id) throw new \Exception("Role invalid!");
        $userData = [
            'username' => trim($this->input('username')),
            'password' => password_hash($this->input('password'), PASSWORD_BCRYPT),
            'role_id'  => $role_id,
            'status'   => 'active'
        ];
        
        $lastUserId = $userModel->create('users', $userData);
        if (!$lastUserId) throw new \Exception("failed to register User");
        if ($this->input('role_name') === 'citizen') {
            $profileData = [
                'full_name'   => $this->input('full_name'),
                'phone'       => $this->input('phone'),
                'nida_number' => $this->input('nida_number'),
                'user_id'     => $lastUserId
            ];
            $res = $userModel->create('citizen_profiles', $profileData);
        } else {
            $profileData = [
                'full_name'   => $this->input('staff_fullname'),
                'phone'      => $this->input('phone'),
                'department' => $this->input('department'),
                'staff_id'   => $this->input('staff_id'),
                'user_id'    => $lastUserId
            ];
            $res = $userModel->create('staff_profiles', $profileData);
        }

        if (!$res) throw new \Exception("failed to register Profile");

        $db->commit();
        return $this->json(['status' => 'success', 'message' => 'user registered successfully!']);

    } catch (\Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        return $this->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
    public function toggleUserStatus() {
        $this->checkAuth();
        
        $userId = $this->input('id');
        $currentStatus = $this->input('status');
        
        if (!$userId) {
            return $this->json(['status' => 'error', 'message' => 'User ID does not exist!'], 400);
        }

        $newStatus = ($currentStatus === 'active') ? 'inactive' : 'active';
        
        $userModel = new UserModel();
        if ($userModel->updateStatus($userId, $newStatus)) {
            return $this->json([
                'status'     => 'success',
                'new_status' => $newStatus,
                'message'    => "Account  is  $newStatus"
            ]);
        }
        
        return $this->json(['status' => 'error', 'message' => 'Failed to change'], 500);
    }
   public function deleteUser() {
    $this->checkAuth();
    $userId = (int)$this->input('id');

    if (!$userId) {
        return $this->json(['status' => 'error', 'message' => 'User ID not exist'], 400);
    }

    $userModel = new UserModel();
    $db =Database::getConnection();

    try {
        $db->beginTransaction();
        $userModel->deleteByColumn('staff_profiles', 'user_id', $userId);
        $userModel->deleteByColumn('citizen_profiles', 'user_id', $userId);

        if (!$userModel->delete('users', $userId)) {
            throw new \Exception("failed to delete main user.");
        }

        $db->commit();
        return $this->json(['status' => 'success', 'message' => 'user information delete succesfully']);

    } catch (\Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        return $this->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
public function getPermissions() {
    $userId = (int)($_GET['id'] ?? 0);
    $permModel = new PermissionModel();
    $perms = $permModel->getByUserId($userId);
    header('Content-Type: application/json');
    echo json_encode($perms ?: ['user_id' => $userId]);
    exit;
}
public function savePermissions() {
    $permModel = new PermissionModel();
    $data = [
        'user_id'    => $this->input('user_id'),
        'department' => $this->input('department'),
        'can_verify_payment'   => $this->input('can_verify_payment') ? 1 : 0,
        'can_review_documents' => $this->input('can_review_documents') ? 1 : 0,
    ];

    if ($permModel->savePermissions($data)) {
        return $this->json(['status' => 'success', 'message' => 'Permission updated!']);
    }
}
   public function profile() {
        $user = $this->checkAuth();
        if (!$user) return $this->redirect('/login');
        $model = new StaffModel();
        return $this->view('/dashboard/pages/profile', ['profile' => $model->getProfile($user['id'])]);
    }
}