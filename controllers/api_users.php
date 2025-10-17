<?php
// Simple REST-ish API for user management
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../app/models/UserModel.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? null;
$model = new UserModel();

try {
    if ($method === 'GET') {
        if ($action === 'get' && isset($_GET['id'])) {
            $user = $model->getUserById((int)$_GET['id']);
            if ($user) echo json_encode(['success' => true, 'data' => $user]);
            else echo json_encode(['success' => false, 'message' => 'User not found']);
            exit;
        }

        // list with optional filters
        $filters = [];
        if (isset($_GET['role'])) $filters['role'] = $_GET['role'];
        if (isset($_GET['status'])) $filters['status'] = $_GET['status'];
        if (isset($_GET['q'])) {
            $users = $model->searchUsers($_GET['q'], $filters);
            echo json_encode(['success' => true, 'data' => $users]);
            exit;
        }

        $users = $model->getAllUsers($filters);
        echo json_encode(['success' => true, 'data' => $users]);
        exit;
    }

    if ($method === 'POST') {
        // Accept form-encoded or JSON body
        $input = $_POST;
        if (empty($input)) {
            $raw = file_get_contents('php://input');
            $input = json_decode($raw, true) ?? [];
        }

        if ($action === 'create') {
            // Basic validation
            $required = ['username','email','fullName','role','status','password'];
            foreach ($required as $f) {
                if (empty($input[$f])) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => "Missing field: $f"]);
                    exit;
                }
            }

            $ok = $model->createUser([
                'username' => $input['username'],
                'password' => $input['password'],
                'email' => $input['email'],
                'fullName' => $input['fullName'],
                'role' => $input['role'],
                'status' => $input['status'],
                'createdBy' => $input['createdBy'] ?? null
            ]);
            echo json_encode(['success' => (bool)$ok]);
            exit;
        }

        if ($action === 'update' && isset($input['id'])) {
            $id = (int)$input['id'];
            $ok = $model->updateUser($id, [
                'username' => $input['username'] ?? null,
                'email' => $input['email'] ?? null,
                'fullName' => $input['fullName'] ?? null,
                'role' => $input['role'] ?? null,
                'status' => $input['status'] ?? null
            ]);
            echo json_encode(['success' => (bool)$ok]);
            exit;
        }

        if ($action === 'delete' && isset($input['id'])) {
            $id = (int)$input['id'];
            $ok = $model->deleteUser($id);
            echo json_encode(['success' => (bool)$ok]);
            exit;
        }

        if ($action === 'bulkApprove' && isset($input['ids'])) {
            $ids = is_array($input['ids']) ? $input['ids'] : json_decode($input['ids'], true);
            $ok = $model->bulkUpdateStatus($ids, 'active');
            echo json_encode(['success' => (bool)$ok]);
            exit;
        }

        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit;
    }

    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>