<?php
namespace App\Models;

class UserModel extends Model {
    
    public function getAllUsers() {
        return $this->join('users', 'roles', 'users.role_id = roles.id');
    }
    public function findForLogin($username) {
        $sql = "SELECT users.*, roles.name as role_name 
                FROM users 
                JOIN roles ON users.role_id = roles.id 
                WHERE users.username = ? LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    public function findByUsername($username) {
        $result = $this->where('users', ['username' => $username]);
        return !empty($result) ? $result[0] : null;
    }
    public function updateStatus($userId, $newStatus) {
        return $this->update('users', ['status' => $newStatus], $userId);
    }
    public function countByStatus($status) {
        return $this->count('users', ['status' => $status]);
    }
}