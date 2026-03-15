<?php
namespace App\Models;

class ActivityModel extends Model {

    public function log($userId, $action) {
        return $this->create('activity_logs', [
            'user_id'    => $userId,
            'action'     => $action,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }


    public function getByUser($userId) {
        return $this->where('activity_logs', ['user_id' => $userId]);
    }

    public function countByUser($userId) {
        $sql = "SELECT COUNT(*) as total FROM activity_logs WHERE user_id = ?";
        $result = $this->customQuery($sql, [$userId]);
        return $result[0]['total'] ?? 0;
    }

    public function getPaginatedByUser($userId, $limit, $offset) {
        $sql = "SELECT * FROM activity_logs 
                WHERE user_id = ? 
                ORDER BY created_at DESC 
                LIMIT $limit OFFSET $offset";
        return $this->customQuery($sql, [$userId]);
    }
}