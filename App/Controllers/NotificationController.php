<?php
namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\User;
use App\Models\Model;

class NotificationController extends Controller {

    public function index() {
        $user = $this->checkAuth();
        $notifModel = new NotificationModel();
        
        return $this->view('dashboard/pages/notifications', [
            'notifications' => $notifModel->getForUser($user['id']),
            'title' => 'My Notifications'
        ]);
    }

    public function countUnread() {
        $user = $this->checkAuth();
        $model = new Model();
        $unread = $model->where('notifications', ['user_id' => $user['id'], 'is_read' => 0]);
        return $this->json(['count' => count($unread)]);
    }

    public function latest() {
        $user = $this->checkAuth();
        $model = new Model();
        $sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
        $notifs = $model->raw($sql, [$user['id']]);
        return $this->json(['notifications' => $notifs]);
    }

    public function read() {
        $id = $this->input('id');
        $model = new Model();
        if($model->update('notifications', ['is_read' => 1], $id)) {
            return $this->json(['status' => 'success']);
        }
    }
}