<?php
require_once __DIR__ . '/app/models/UserModel.php';

$userModel = new UserModel();
try {
    // Get the user first
    $user = $userModel->getUserByUsername('jacob');
    if ($user) {
        // Update the status to active
        $userData = [
            'username' => $user['username'],
            'email' => $user['email'],
            'fullName' => $user['full_name'],
            'role' => $user['role'],
            'status' => 'active'
        ];
        
        if ($userModel->updateUser($user['id'], $userData)) {
            echo "Account activated successfully!";
        } else {
            echo "Failed to activate account.";
        }
    } else {
        echo "User not found.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>