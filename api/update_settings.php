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
    $pdo = new PDO("sqlite:../database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT OR REPLACE INTO settings (key, value, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP)");
    $stmt->execute([$key, $value]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 