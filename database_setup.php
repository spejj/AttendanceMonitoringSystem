<?php
require_once 'database/connection.php';

try {
    // Get database connection
    $conn = Database::getInstance()->getConnection();
    
    echo "Connected successfully. Starting database updates...<br>";

    // Function to check if a column exists
    function columnExists($conn, $table, $column) {
        $sql = "SHOW COLUMNS FROM `$table` LIKE '$column'";
        $result = $conn->query($sql);
        return $result->rowCount() > 0;
    }

    // Function to check if a table exists
    function tableExists($conn, $table) {
        try {
            $result = $conn->query("SELECT 1 FROM `$table` LIMIT 1");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Start transaction
    $conn->beginTransaction();

    // 1. Modify users table
    if (tableExists($conn, 'users')) {
        echo "Modifying users table...<br>";
        
        // Add role column if it doesn't exist
        if (!columnExists($conn, 'users', 'role')) {
            $conn->exec("ALTER TABLE users ADD COLUMN role ENUM('admin', 'instructor', 'student', 'parent') NOT NULL");
            echo "Added role column<br>";
        }

        // Add status column if it doesn't exist
        if (!columnExists($conn, 'users', 'status')) {
            $conn->exec("ALTER TABLE users ADD COLUMN status ENUM('active', 'inactive', 'pending') NOT NULL DEFAULT 'pending'");
            echo "Added status column<br>";
        }

        // Add created_by column if it doesn't exist
        if (!columnExists($conn, 'users', 'created_by')) {
            $conn->exec("ALTER TABLE users ADD COLUMN created_by INT");
            echo "Added created_by column<br>";
        }

        // Add created_at column if it doesn't exist
        if (!columnExists($conn, 'users', 'created_at')) {
            $conn->exec("ALTER TABLE users ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
            echo "Added created_at column<br>";
        }

        // Add last_active column if it doesn't exist
        if (!columnExists($conn, 'users', 'last_active')) {
            $conn->exec("ALTER TABLE users ADD COLUMN last_active TIMESTAMP NULL");
            echo "Added last_active column<br>";
        }
    } else {
        // Create users table if it doesn't exist
        $sql = "CREATE TABLE users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            full_name VARCHAR(100) NOT NULL,
            role ENUM('admin', 'instructor', 'student', 'parent') NOT NULL,
            status ENUM('active', 'inactive', 'pending') NOT NULL DEFAULT 'pending',
            created_by INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            last_active TIMESTAMP NULL
        )";
        $conn->exec($sql);
        echo "Created users table<br>";
    }

    // 2. Create subjects table
    if (!tableExists($conn, 'subjects')) {
        $sql = "CREATE TABLE subjects (
            id INT PRIMARY KEY AUTO_INCREMENT,
            code VARCHAR(10) NOT NULL,
            name VARCHAR(100) NOT NULL,
            capacity INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
        echo "Created subjects table<br>";
    }

    // 3. Create class_sections table
    if (!tableExists($conn, 'class_sections')) {
        $sql = "CREATE TABLE class_sections (
            id INT PRIMARY KEY AUTO_INCREMENT,
            subject_id INT,
            section_name VARCHAR(20) NOT NULL,
            instructor_id INT,
            schedule_json JSON,
            FOREIGN KEY (subject_id) REFERENCES subjects(id),
            FOREIGN KEY (instructor_id) REFERENCES users(id)
        )";
        $conn->exec($sql);
        echo "Created class_sections table<br>";
    }

    // 4. Create announcements table
    if (!tableExists($conn, 'announcements')) {
        $sql = "CREATE TABLE announcements (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(200) NOT NULL,
            message TEXT NOT NULL,
            target_type ENUM('all', 'students', 'instructors', 'parents', 'class') NOT NULL,
            target_id INT,
            created_by INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (created_by) REFERENCES users(id)
        )";
        $conn->exec($sql);
        echo "Created announcements table<br>";
    }

    // 5. Create activity_logs table
    if (!tableExists($conn, 'activity_logs')) {
        $sql = "CREATE TABLE activity_logs (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT,
            action_type ENUM('attendance', 'grades', 'users', 'system') NOT NULL,
            description TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )";
        $conn->exec($sql);
        echo "Created activity_logs table<br>";
    }

    // Create default admin user if users table is empty
    $stmt = $conn->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, full_name, role, status) 
                VALUES ('admin', :password, 'admin@example.com', 'System Administrator', 'admin', 'active')";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['password' => $hashedPassword]);
        echo "Created default admin user (username: admin, password: admin123)<br>";
    }

    // Commit transaction
    $conn->commit();
    echo "All database updates completed successfully!<br>";
    echo "You can now log in with the default admin account (if created):<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";

} catch(PDOException $e) {
    // Rollback transaction on error
    if ($conn) {
        $conn->rollBack();
    }
    echo "Error: " . $e->getMessage() . "<br>";
}

$conn = null;
?>