<?php

require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function createUser($data) {
        // Hash password if it's provided and not already hashed
        if (isset($data['password']) && strlen($data['password']) < 60) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        $sql = "INSERT INTO users (username, password, email, role, status, full_name) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['username'], 
            $data['password'], 
            $data['email'], 
            $data['role'], 
            $data['status'],
            $data['fullName'] ?? null
        ];
        return $this->db->query($sql, $params);
    }

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        return $this->db->query($sql, [$username])->fetch();
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->db->query($sql, [$email])->fetch();
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function getAllUsers($filters = []) {
        $sql = "SELECT * FROM users WHERE 1=1";
        $params = [];
        
        if (isset($filters['role'])) {
            $sql .= " AND role = ?";
            $params[] = $filters['role'];
        }
        
        if (isset($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        return $this->db->query($sql, $params)->fetchAll();
    }

    public function searchUsers($query, $filters = []) {
        $sql = "SELECT * FROM users WHERE (username LIKE ? OR email LIKE ? OR full_name LIKE ?)";
        $params = ["%$query%", "%$query%", "%$query%"];
        
        if (isset($filters['role'])) {
            $sql .= " AND role = ?";
            $params[] = $filters['role'];
        }
        
        if (isset($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        return $this->db->query($sql, $params)->fetchAll();
    }

    public function updateUser($id, $data) {
        $sql = "UPDATE users SET ";
        $params = [];
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $sql .= "$key = ?, ";
                $params[] = $value;
            }
        }
        $sql = rtrim($sql, ", ") . " WHERE id = ?";
        $params[] = $id;
        return $this->db->query($sql, $params);
    }

    public function updateLastActive($userId) {
        return $this->updateUser($userId, ['last_active' => date('Y-m-d H:i:s')]);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function bulkUpdateStatus($ids, $status) {
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $sql = "UPDATE users SET status = ? WHERE id IN ($placeholders)";
        $params = array_merge([$status], $ids);
        return $this->db->query($sql, $params);
    }

    public function activateAccount($userId) {
        return $this->updateUser($userId, ['status' => 'active']);
    }
}