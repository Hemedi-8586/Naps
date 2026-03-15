<?php
namespace App\Controllers;

use App\Models\Model;
use App\Models\ActivityModel;

class PermitController extends Controller {
public function review() {
    $this->checkAuth();
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $model = new Model();
    $result = $model->getDetailedPermits($page);

    return $this->view('dashboard/pages/review', [
        'title'       => 'Permit Review Queue',
        'permits'     => $result['data'],
        'totalPages'  => $result['totalPages'],
        'currentPage' => $result['currentPage']
    ]);
}
public function handleDecision() {
    $user = $this->checkAuth();
    $data = $this->getJsonInput(); 
    
    $permitId = isset($data['id']) ? (int)$data['id'] : null;
    $status   = $data['status'] ?? null; 
    $comment  = $data['comment'] ?? '';

    if (!$permitId || !$status) {
        return $this->json(['status' => 'error', 'message' => 'Missing data'], 400);
    }

    $model = new Model();
  
    $updateData = [
        'status'              => $status,
        'inspection_comments' => $comment,
        'inspected_at'        => date('Y-m-d H:i:s')
       
    ];

    $update = $model->updateWhere('permits', $updateData, ['id' => $permitId]);

    if ($update !== false) {
        $activity = new ActivityModel();
        $activity->log($user['id'], "Permit #$permitId set to $status");
        
        return $this->json([
            'status' => 'success', 
            'message' => "Permit " . ucfirst($status) . " successfully"
        ]);
    }

    return $this->json(['status' => 'error', 'message' => 'Update failed. Check database columns.'], 500);
}
}