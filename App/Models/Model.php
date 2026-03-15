<?php
namespace App\Models;

use Config\Database;
use PDO;
use Exception;

class Model {
    public $db;
    protected $table;
    

    public function __construct() {
        $this->db = Database::getConnection();

        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    public function customQuery($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            
            if (stripos(trim($sql), 'SELECT') === 0) {
                return $stmt->fetchAll();
            }
            return true;
        } catch (Exception $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    public function exists($table, $column, $value) {
        $sql = "SELECT id FROM {$table} WHERE {$column} = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetch() !== false;
    }

    public function create($table, $data) {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            
            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute(array_values($data)) ? $this->db->lastInsertId() : false;
        } catch (Exception $e) {
            error_log("Create Error: " . $e->getMessage());
            return false;
        }
    }

    public function find($table, $id) {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function all($table, $orderBy = 'id DESC') {
        $stmt = $this->db->query("SELECT * FROM $table ORDER BY $orderBy");
        return $stmt->fetchAll() ?: [];
    }

    public function where($table, $conditions) {
        $where = implode(' AND ', array_map(fn($k) => "$k = ?", array_keys($conditions)));
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $where ORDER BY id DESC");
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll() ?: [];
    }

    public function update($table, $data, $id) {
        try {
            $fields = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
            $sql = "UPDATE $table SET $fields WHERE id = ?";
            $values = array_values($data);
            $values[] = $id; 
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($values);
        } catch (Exception $e) {
            error_log("Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($table, $id) {
        $stmt = $this->db->prepare("DELETE FROM $table WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function join($table1, $table2, $on, $conditions = []) {
        $whereClause = "";
        $values = [];
        if (!empty($conditions)) {
            $whereClause = " WHERE " . implode(' AND ', array_map(fn($k) => "$k = ?", array_keys($conditions)));
            $values = array_values($conditions);
        }
        $sql = "SELECT * FROM $table1 JOIN $table2 ON $on $whereClause";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll() ?: [];
    }

    public function count($table, $conditions = []) {
        $whereClause = "";
        $values = [];
        if (!empty($conditions)) {
            $whereClause = " WHERE " . implode(' AND ', array_map(fn($k) => "$k = ?", array_keys($conditions)));
            $values = array_values($conditions);
        }
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM $table $whereClause");
        $stmt->execute($values);
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    public function findWhere($table, $conditions) {
        $where = implode(' AND ', array_map(fn($k) => "$k = ?", array_keys($conditions)));
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $where LIMIT 1");
        $stmt->execute(array_values($conditions));
        return $stmt->fetch() ?: null;
    }

    public function updateWhere($table, $data, $conditions) {
        try {
            $fields = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
            $where = implode(' AND ', array_map(fn($k) => "$k = ?", array_keys($conditions)));
            $sql = "UPDATE $table SET $fields WHERE $where";
            $values = array_merge(array_values($data), array_values($conditions));
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($values);
        } catch (Exception $e) {
            error_log("UpdateWhere Error: " . $e->getMessage());
            return false;
        }
    }

    public function raw($sql, $params = []) {
        return $this->customQuery($sql, $params);
    }

    public function upsert($table, $data, $uniqueColumn = 'user_id') {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $updates = [];
            foreach ($data as $key => $value) {
                if ($key !== $uniqueColumn) {
                    $updates[] = "$key = VALUES($key)";
                }
            }
            $updateStr = implode(', ', $updates);
            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders) 
                    ON DUPLICATE KEY UPDATE $updateStr";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(array_values($data));
        } catch (Exception $e) {
            error_log("Upsert Error: " . $e->getMessage());
            return false;
        }
    }

    public function getPaginatedData($limit, $offset) {
        $tableName = !empty($this->table) ? $this->table : 'users';
        $sql = "SELECT u.id, u.username, u.status, r.name AS role_name,
                COALESCE(s.full_name, c.full_name, u.username) AS display_name
                FROM $tableName AS u
                LEFT JOIN roles r ON u.role_id = r.id
                LEFT JOIN staff_profiles s ON u.id = s.user_id 
                LEFT JOIN citizen_profiles c ON u.id = c.user_id
                ORDER BY u.id DESC LIMIT :limit OFFSET :offset"; 

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }
    public function getStaffProfile($userId) {
        $sql = "SELECT u.username, u.email, u.status, r.name as role_name, 
                       s.full_name, s.employee_id, s.phone, s.department, s.designation, s.profile_pic
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                LEFT JOIN staff_profiles s ON u.id = s.user_id
                WHERE u.id = ? LIMIT 1";
        
        $res = $this->raw($sql, [$userId]);
        return (!empty($res)) ? $res[0] : null;
    }
    public function getPendingReviews() {
    $sql = "SELECT a.*, c.full_name, c.phone, c.nida_number 
            FROM applications a 
            LEFT JOIN citizen_profiles c ON a.user_id = c.user_id 
            ORDER BY a.created_at DESC";
    return $this->raw($sql);
    }public function getDetailedPermits($page = 1) {
    $limit = 3;
    $currentPage = (int)$page; 
    if ($currentPage < 1) $currentPage = 1;
    
    $offset = (int)($currentPage - 1) * $limit;

    
    $countRes = $this->raw("SELECT COUNT(*) as total FROM permits");
    $totalCount = (int)($countRes[0]['total'] ?? 0);
    $totalPages = (int)ceil($totalCount / $limit);

    $sql = "SELECT p.*, cp.full_name, cp.nida_number, cp.phone, 
                   pay.payment_type, pay.status as payment_status, pay.amount
            FROM permits p
            LEFT JOIN citizen_profiles cp ON p.applicant_id = cp.user_id
            LEFT JOIN payments pay ON p.id = pay.application_id
            ORDER BY p.created_at DESC 
            LIMIT $limit OFFSET $offset";
            
    return [
        'data' => $this->raw($sql),
        'totalPages' => $totalPages,
        'currentPage' => $currentPage
    ];
}
public function updatePermitStatus($id, $status, $comment) {
    $sql = "UPDATE permits SET status = ?, remarks = ? WHERE id = ?";
    return $this->customQuery($sql, [$status, $comment, $id]);
}
}