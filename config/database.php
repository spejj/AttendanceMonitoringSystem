<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'ams');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create database connection
function getDBConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
            DB_USER, 
            DB_PASS
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Function to log activity
function logActivity($userId, $actionType, $description) {
    try {
        $conn = getDBConnection();
        $sql = "INSERT INTO activity_logs (user_id, action_type, description) VALUES (:userId, :actionType, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'userId' => $userId,
            'actionType' => $actionType,
            'description' => $description
        ]);
        return true;
    } catch(PDOException $e) {
        error_log("Error logging activity: " . $e->getMessage());
        return false;
    }
}

// Function to update user's last active timestamp
function updateUserLastActive($userId) {
    try {
        $conn = getDBConnection();
        $sql = "UPDATE users SET last_active = CURRENT_TIMESTAMP WHERE id = :userId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return true;
    } catch(PDOException $e) {
        error_log("Error updating last active: " . $e->getMessage());
        return false;
    }
}

// Function to create announcement
function createAnnouncement($title, $message, $targetType, $targetId, $createdBy) {
    try {
        $conn = getDBConnection();
        $sql = "INSERT INTO announcements (title, message, target_type, target_id, created_by) 
                VALUES (:title, :message, :targetType, :targetId, :createdBy)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'message' => $message,
            'targetType' => $targetType,
            'targetId' => $targetId,
            'createdBy' => $createdBy
        ]);
        return true;
    } catch(PDOException $e) {
        error_log("Error creating announcement: " . $e->getMessage());
        return false;
    }
}
?>