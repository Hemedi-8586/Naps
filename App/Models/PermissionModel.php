<?php
namespace App\Models;

class PermissionModel extends Model {
    protected $table = 'permissions';

    public function getByUserId($userId) {
        return $this->findWhere($this->table, ['user_id' => $userId]);
    }

    public function savePermissions($data) {
        return $this->upsert($this->table, $data, 'user_id');
    }
}