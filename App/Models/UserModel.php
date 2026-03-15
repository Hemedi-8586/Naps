<?php
namespace App\Models;

use PDO;

class UserModel extends Model {
    protected $table = "users";

    public function getAllUsers() {
        return $this->join('users', 'roles', 'users.role_id = roles.id');
    }

    public function findByUsername($username) {
        $result = $this->where('users', ['username' => $username]);
        
        return (!empty($result) && isset($result[0])) ? $result[0] : null;
    }

    public function findForLogin($username) {
        return $this->findWithRole($username);
    }

    public function findWithRole($username) {
        $sql = "SELECT u.*, r.name as role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.username = ? LIMIT 1";
        
        $result = $this->raw($sql, [$username]);
        return (!empty($result) && isset($result[0])) ? $result[0] : null;
    }

    public function updateStatus($userId, $newStatus) {
        return $this->update('users', ['status' => $newStatus], $userId);
    }

    public function countByRole($roleId) {
        return $this->count('users', ['role_id' => $roleId]);
    }

    public function getUsersWithProfiles($limit, $offset) {
        return $this->getPaginatedData($limit, $offset);
    }

    public function getSettings($userId) {
        $sql = "SELECT theme_preference, language_preference FROM users WHERE id = ?";
        $res = $this->raw($sql, [$userId]);
        if (!empty($res) && isset($res[0])) {
            return $res[0];
        }
        return ['theme_preference' => 'light', 'language_preference' => 'sw'];
    }
}