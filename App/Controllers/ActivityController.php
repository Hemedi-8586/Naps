<?php
namespace App\Controllers;

use App\Models\ActivityModel;

class ActivityController extends Controller {

    public function index() {
        $user = $this->checkAuth();
        if (!$user) return $this->redirect('/login');

        $model = new ActivityModel();

        
        $limit = 2; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        
        $totalRecords = $model->countByUser($user['id']);
        $totalPages = ceil($totalRecords / $limit);

        
        $activities = $model->getPaginatedByUser($user['id'], $limit, $offset);

        return $this->view('dashboard/pages/activity', [
            'activities'  => $activities,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'title'       => 'My Activity Log'
        ]);
    }
}