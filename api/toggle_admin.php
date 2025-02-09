<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Check if user is authenticated and is admin
if (!isAuthenticated() || !getCurrentUser()['is_admin']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

// Validate user_id parameter
if (!isset($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid user ID']);
    exit();
}

$userId = intval($_POST['user_id']);

try {
    // Start transaction
    $pdo->beginTransaction();

    // Get current admin status
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $currentStatus = $stmt->fetchColumn();

    if ($currentStatus === false) {
        throw new Exception('User not found');
    }

    // Toggle admin status
    $stmt = $pdo->prepare("UPDATE users SET is_admin = NOT is_admin WHERE id = ?");
    $stmt->execute([$userId]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 