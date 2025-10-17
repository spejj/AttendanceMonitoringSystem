<?php
session_start();
require_once __DIR__ . '/../app/models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login($username, $password, $role = null) {
        try {
            error_log("Login attempt - Username: " . $username . ", Role: " . $role);
            $user = $this->userModel->getUserByUsername($username);
            
            if (!$user) {
                error_log("Login failed - User not found: " . $username);
                return [
                    'success' => false,
                    'message' => 'Invalid username or password'
                ];
            }

            // Check if account is active
            if ($user['status'] !== 'active') {
                error_log("Login failed - Account not active for user: " . $username);
                return [
                    'success' => false,
                    'message' => 'Your account is pending approval'
                ];
            }

            // Debug password verification
            error_log("Stored password hash: " . $user['password']);
            error_log("Password verification result: " . (password_verify($password, $user['password']) ? 'true' : 'false'));

            if (!password_verify($password, $user['password'])) {
                error_log("Login failed - Invalid password for user: " . $username);
                return [
                    'success' => false,
                    'message' => 'Invalid username or password'
                ];
            }
            
            if ($user && password_verify($password, $user['password'])) {
                // Verify role matches if provided
                if ($role && strtolower($user['role']) !== strtolower($role)) {
                    return [
                        'success' => false,
                        'message' => 'Invalid role for this account'
                    ];
                }
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];

                // Update last active timestamp
                $this->userModel->updateLastActive($user['id']);

                // Log the activity
                require_once '../database/models/ActivityLogModel.php';
                $activityLog = new ActivityLogModel();
                $activityLog->logActivity([
                    'userId' => $user['id'],
                    'actionType' => 'system',
                    'description' => 'User logged in'
                ]);

                return [
                    'success' => true,
                    'redirect' => $this->getRedirectUrl($user['role'])
                ];
            }

            return [
                'success' => false,
                'message' => 'Invalid username or password'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred during login'
            ];
        }
    }

    private function getRedirectUrl($role) {
        switch ($role) {
            case 'admin':
                return 'admin-dashboard.php';
            case 'instructor':
                return 'instructor-dashboard.php';
            case 'student':
            case 'parent':
                return 'student-parent.php';
            default:
                return 'index.php';
        }
    }

    public function logout() {
        if (isset($_SESSION['user_id'])) {
            // Log the activity before destroying session
            require_once '../database/models/ActivityLogModel.php';
            $activityLog = new ActivityLogModel();
            $activityLog->logActivity([
                'userId' => $_SESSION['user_id'],
                'actionType' => 'system',
                'description' => 'User logged out'
            ]);
        }

        // Destroy session
        session_destroy();
        return ['success' => true, 'redirect' => 'index.php'];
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController();
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                $response = $auth->login(
                    $_POST['username'] ?? '',
                    $_POST['password'] ?? '',
                    $_POST['role'] ?? null
                );
                break;
            case 'logout':
                $response = $auth->logout();
                break;
            default:
                $response = ['success' => false, 'message' => 'Invalid action'];
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
?>