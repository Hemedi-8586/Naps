<?php
namespace App\Controllers;
use App\Models\Model;
use App\Models\UserModel;
use App\Models\ActivityModel; 

class AuthController extends Controller {
    
    public function login() {
        if ($this->checkAuth()) {
            $this->redirect('/dashboard'); 
        }
        return $this->publicView('auth/login');
    }

    public function handleLogin() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $username = $data['username'] ?? $this->input('username');
        $password = $data['password'] ?? $this->input('password');

        if (!$username || !$password) {
            return $this->json(['status' => 'error', 'message' => 'please username and password'], 400);
        }

        $userModel = new UserModel();
        $user = $userModel->findForLogin($username);

        if ($user && password_verify($password, $user['password'])) {
            $cleanRole = strtolower(trim($user['role_name']));
            $payload = [
                'id' => (int)$user['id'],
                'username' => (string)$user['username'],
                'role_name' => (string)$cleanRole 
            ];

            $token = $this->jwt->generateToken($payload, 86400); 

            $activity = new ActivityModel();
            $activity->log($user['id'], "User login successfully (Login)");

            setcookie('auth_token', $token, [
                'expires' => time() + 86400,
                'path' => '/naps/', 
                'httponly' => true,
                'samesite' => 'Lax'
            ]);

            return $this->json([
                'status' => 'success', 
                'message' => 'welcome back, ' . $user['username'], 
                'redirect' => '/naps/dashboard', 
                'token' => $token,
            ]);
        }

        return $this->json(['status' => 'error', 'message' => 'Username or Password is invalid'], 401);
    }

    public function logout() {
        $user = $this->checkAuth();
        if ($user) {
            $activity = new ActivityModel();
            $activity->log($user['id'], "user logged out (Logout)");
        }

        setcookie('auth_token', '', time() - 3600, '/naps/');
        $this->redirect('/login'); 
    }

    public function processRegister() {
        $full_name   = trim($this->input('full_name')); 
        $nida_number = trim($this->input('nida_number'));
        $phone       = trim($this->input('phone'));
        $username    = trim($this->input('username'));
        $password    = $this->input('password');

        if (!$full_name || !$username || !$password) {
            return $this->json(['status' => 'error', 'message' => 'Fill name, Username and Password'], 400);
        }

        $userModel = new UserModel();

        if ($userModel->exists('users', 'username', $username)) {
            return $this->json(['status' => 'error', 'message' => 'Username Already exist!'], 400);
        }

        if ($userModel->exists('citizen_profiles', 'nida_number', $nida_number)) {
            return $this->json(['status' => 'error', 'message' => 'NIDA Already registered!'], 400);
        }

        $userId = $userModel->create('users', [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role_id'  => 3, 
            'status'   => 'active'
        ]);

        if ($userId) {
            $userModel->create('citizen_profiles', [
                'full_name'   => $full_name,
                'user_id'     => $userId, 
                'nida_number' => $nida_number,
                'phone'       => $phone
            ]);
            $activity = new ActivityModel();
            $activity->log($userId, "New account registered: $username");

            return $this->json(['status' => 'success', 'message' => 'registration complete welcome NAPS.']);
        }

        return $this->json(['status' => 'error', 'message' => 'An occured please try again '], 500);
    }

    public function registerForm() {
        return $this->publicView('auth/register', [
            'title' => 'NAPS | register as citizen'
        ]);
    }
}