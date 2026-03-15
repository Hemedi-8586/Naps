<?php
namespace App\Models;

class PaymentModel extends Model {
    public function getUserPayments($userId) {
        $sql = "SELECT p.*, pr.permit_type 
                FROM payments p 
                JOIN permits pr ON p.application_id = pr.id 
                WHERE p.user_id = ? 
                ORDER BY p.created_at DESC";
        return $this->raw($sql, [$userId]);
    }
    public function updateControlNumber($id, $controlNumber) {
        return $this->update('payments', ['control_number' => $controlNumber], $id);
    }
    public function completePayment($id) {
        return $this->update('payments', [
            'status' => 'Paid',
            'payment_date' => date('Y-m-d H:i:s')
        ], $id);
    }
}