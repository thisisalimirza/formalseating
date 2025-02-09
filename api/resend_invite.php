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

// Validate email
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email address']);
    exit();
}

try {
    // Check if email is approved and not registered
    $stmt = $pdo->prepare("
        SELECT ae.email 
        FROM approved_emails ae
        LEFT JOIN users u ON ae.email = u.email
        WHERE ae.email = ? AND u.id IS NULL
    ");
    $stmt->execute([$email]);
    
    if (!$stmt->fetch()) {
        http_response_code(400);
        echo json_encode(['error' => 'Email not found or already registered']);
        exit();
    }

    // TODO: Implement email sending functionality here
    // For now, we'll just return success
    // You can integrate with your preferred email service (SendGrid, AWS SES, etc.)
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log("Error resending invite: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 