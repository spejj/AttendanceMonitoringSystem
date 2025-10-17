<?php
require_once __DIR__ . '/app/models/UserModel.php';

function createAdminUser() {
    try {
        $userModel = new UserModel();
        
        // Check if admin exists
        $existingAdmin = $userModel->getUserByUsername('admin');
        if ($existingAdmin) {
            echo "Admin user already exists. Updating password...<br>";
            // You might want to add update password functionality here
            return;
        }

        // Create new admin user
        $password = 'admin123';
        $userData = [
            'username' => 'admin',
            'password' => $password, // Will be hashed by UserModel
            'email' => 'admin@example.com',
            'fullName' => 'System Administrator',
            'role' => 'admin',
            'status' => 'active'
        ];

        if ($userModel->createUser($userData)) {
            echo "Admin user created successfully!<br>";
            echo "Username: admin<br>";
            echo "Password: admin123<br>";
        } else {
            echo "Failed to create admin user.<br>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Execute
createAdminUser();
?>