<?php
require_once 'database/connection.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Check if users table exists
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Existing tables:<br>";
    print_r($tables);
    echo "<br><br>";

    // Check users table structure
    $structure = $db->query("DESCRIBE users")->fetchAll(PDO::FETCH_ASSOC);
    echo "Users table structure:<br>";
    print_r($structure);
    echo "<br><br>";

    // Check all users in the database
    $users = $db->query("SELECT id, username, email, role, status, full_name FROM users")->fetchAll(PDO::FETCH_ASSOC);
    echo "Registered users:<br>";
    print_r($users);
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>