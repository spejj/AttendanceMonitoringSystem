<?php
require_once __DIR__ . '/app/models/UserModel.php';

$userModel = new UserModel();
$username = 'jacob';
$user = $userModel->getUserByUsername($username);

if ($user) {
    echo "User found:<br>";
    echo "Username: " . $user['username'] . "<br>";
    echo "Role: " . $user['role'] . "<br>";
    echo "Status: " . $user['status'] . "<br>";
    // Do not display the actual password hash for security
    echo "Has password hash: " . (!empty($user['password']) ? 'Yes' : 'No') . "<br>";
} else {
    echo "User not found";
}
?>