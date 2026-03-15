<?php

namespace App\Models;

class NotificationModel extends Model {
    
    public function getForUser($userId) {
        return $this->where('notifications', ['user_id' => $userId]);
    }

    public function send($userId, $message) {
        return $this->create('notifications', [
            'user_id'    => $userId,
            'message'    => $message,
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}