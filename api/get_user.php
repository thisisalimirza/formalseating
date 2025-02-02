<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Check if user is authenticated
if (!isAuthenticated()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Validate input
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing id parameter']);
    exit();
}

$userId = (int)$_GET['id'];

try {
    $dbUrl = parse_url(getenv("DATABASE_URL"));
    $pdo = new PDO(
        "pgsql:" . sprintf(
            "host=%s;port=%s;user=%s;password=%s;dbname=%s",
            $dbUrl["host"],
            $dbUrl["port"],
            $dbUrl["user"],
            $dbUrl["pass"],
            ltrim($dbUrl["path"], "/")
        )
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if names should be shown
    $stmt = $pdo->query("SELECT value FROM settings WHERE key = 'show_occupied_names'");
    $showNames = $stmt->fetch(PDO::FETCH_COLUMN) === '1';

    if (!$showNames && !getCurrentUser()['is_admin']) {
        http_response_code(403);
        echo json_encode(['error' => 'Names are not visible']);
        exit();
    }

    // Get user info
    $stmt = $pdo->prepare("SELECT id, name FROM users WHERE id = $1");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit();
    }

    echo json_encode($user);
} catch (PDOException $e) {
    error_log("Database error in get_user.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 