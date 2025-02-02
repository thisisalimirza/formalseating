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
if (!isset($_POST['key']) || !isset($_POST['value'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit();
}

$key = $_POST['key'];
$value = $_POST['value'];

// Validate key
$allowedKeys = ['show_occupied_names'];
if (!in_array($key, $allowedKeys)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid setting key']);
    exit();
}

try {
    // Use the PDO instance from config.php
    $stmt = $pdo->prepare("
        INSERT INTO settings (key, value, updated_at) 
        VALUES (?, ?, CURRENT_TIMESTAMP) 
        ON CONFLICT (key) 
        DO UPDATE SET value = EXCLUDED.value, updated_at = CURRENT_TIMESTAMP
    ");
    $stmt->execute([$key, $value]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log("Database error in update_settings.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 