<?php
namespace App\Models;
use App\Models\Model;

class CitizenModel extends Model {
    
    public function getProfile($userId) {
        return $this->findWhere('citizen_profiles', ['user_id' => $userId]);
    }

    public function saveProfile($userId, $data) {
        return $this->updateWhere('citizen_profiles', $data, ['user_id' => $userId]);
    }
}