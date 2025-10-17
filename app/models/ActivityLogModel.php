<?php
require_once 'connection.php';

class ActivityLogModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function logActivity($data) {
        try {
            $sql = "INSERT INTO activity_logs (user_id, action_type, description) 
                    VALUES (:userId, :actionType, :description)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'userId' => $data['userId'],
                'actionType' => $data['actionType'],
                'description' => $data['description']
            ]);
        } catch(PDOException $e) {
            error_log("Error logging activity: " . $e->getMessage());
            return false;
        }
    }

    public function getActivityLogs($filter = []) {
        try {
            $sql = "SELECT al.*, u.full_name as user_name 
                    FROM activity_logs al
                    LEFT JOIN users u ON al.user_id = u.id";
            $params = [];

            if (!empty($filter['actionType'])) {
                $sql .= " WHERE action_type = :actionType";
                $params['actionType'] = $filter['actionType'];
            }

            $sql .= " ORDER BY created_at DESC";
            
            if (!empty($filter['limit'])) {
                $sql .= " LIMIT :limit";
                $params['limit'] = $filter['limit'];
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching activity logs: " . $e->getMessage());
            return [];
        }
    }
}
?>