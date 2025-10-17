<?php
// Simple CLI helper to create a user via UserModel
require_once __DIR__ . '/../app/models/UserModel.php';

if (PHP_SAPI !== 'cli') {
    echo "Run this script from the command line: php create_user.php username email fullName role password\n";
    exit(1);
}

$args = $argv;
if (!isset($args[1]) || !isset($args[2]) || !isset($args[3]) || !isset($args[4]) || !isset($args[5])) {
    echo "Usage: php create_user.php username email fullName role password\n";
    exit(1);
}

$username = $args[1];
$email = $args[2];
$fullName = $args[3];
$role = $args[4];
$password = $args[5];

$model = new UserModel();
$ok = $model->createUser([
    'username' => $username,
    'password' => $password,
    'email' => $email,
    'fullName' => $fullName,
    'role' => $role,
    'status' => 'active'
]);

if ($ok) echo "User created: $username\n";
else echo "Failed to create user\n";

?>