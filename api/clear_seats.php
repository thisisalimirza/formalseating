<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Check if user is authenticated and is admin
if (!isAuthenticated() || !getCurrentUser()['is_admin']) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Validate input
if (!isset($_POST['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing user_id parameter']);
    exit();
}

$userId = (int)$_POST['user_id'];

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

    // Clear user's seats
    $stmt = $pdo->prepare("UPDATE seats SET occupied = 0 WHERE user_id = ?");
    $stmt->execute([$userId]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 