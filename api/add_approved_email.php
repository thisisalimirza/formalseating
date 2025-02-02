<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Check if user is authenticated and is admin
if (!isAuthenticated() || !getCurrentUser()['is_admin']) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Validate email
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email address']);
    exit();
}

try {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM approved_emails WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Email already approved']);
        exit();
    }

    // Add email to approved list
    $stmt = $pdo->prepare("INSERT INTO approved_emails (email) VALUES (?)");
    $stmt->execute([$email]);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} 