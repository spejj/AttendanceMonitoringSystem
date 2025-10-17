<?php
require_once __DIR__ . '/app/models/UserModel.php';

$userModel = new UserModel();
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validation
    $errors = [];
    
    if (empty($fullName)) $errors[] = "Full name is required";
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    if (empty($role)) $errors[] = "Role is required";
    
    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Password match validation
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if username exists
    if ($userModel->getUserByUsername($username)) {
        $errors[] = "Username already exists";
    }
    
    // If no errors, proceed with registration
    if (empty($errors)) {
        $userData = [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'fullName' => $fullName,
            'role' => $role,
            'status' => 'pending'
        ];
        
        if ($userModel->createUser($userData)) {
            $message = "Registration successful! Your account is pending approval.";
            $messageType = "success";
            // Redirect after 3 seconds
            header("Refresh: 3; URL=index.php");
        } else {
            $message = "Registration failed. Please try again.";
            $messageType = "error";
        }
    } else {
        $message = implode("<br>", $errors);
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>AMS - Register</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body class="bg-gray-soft">
    <main class="center-page">
        <div class="card max-w-md">
            <div class="text-center mb-6">
                <h1 class="title">AMS: Registration</h1>
                <p class="muted">Create your account</p>
            </div>

            <?php if ($message): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form id="registerForm" class="form-stack" method="POST">
                <label class="label">Full Name
                    <input name="fullName" class="input" type="text" required />
                </label>

                <label class="label">Username
                    <input name="username" class="input" type="text" required />
                </label>

                <label class="label">Email
                    <input name="email" class="input" type="email" required />
                </label>

                <label class="label">Password
                    <input name="password" class="input" type="password" required />
                </label>

                <label class="label">Confirm Password
                    <input name="confirmPassword" class="input" type="password" required />
                </label>

                <label class="label">Role
                    <select name="role" class="select" required>
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="instructor">Instructor</option>
                        <option value="student">Student/Parent</option>
                    </select>
                </label>

                <button type="submit" class="btn primary w-full">Register</button>

                <p class="text-center mt-4">
                    Already have an account? <a href="index.php" class="link">Login here</a>
                </p>
            </form>
        </div>
    </main>

    <script src="assets/js/main.js"></script>
</body>
</html>