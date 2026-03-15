<?php
namespace App\Models;
use App\Models\Model;

class StaffModel extends Model {

    public function getProfile($userId) {
        return $this->getStaffProfile($userId);
    }

    public function updateStaffData($userId, $data) {
        return $this->updateWhere('staff_profiles', $data, ['user_id' => $userId]);
    }
}