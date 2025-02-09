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
    // Begin transaction
    $pdo->beginTransaction();

    // Clear all seats for the user
    $stmt = $pdo->prepare("
        UPDATE seats 
        SET occupied = false 
        WHERE user_id = ? AND occupied = true
    ");
    $stmt->execute([$userId]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Error clearing seats: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to clear seats']);
}
?> 