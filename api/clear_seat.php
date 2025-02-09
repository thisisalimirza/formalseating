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

// Validate input
if (!isset($_POST['seat_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing seat_id parameter']);
    exit();
}

$seatId = intval($_POST['seat_id']);

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Clear the seat
    $stmt = $pdo->prepare("
        UPDATE seats 
        SET occupied = false, user_id = NULL 
        WHERE seat_id = ?
    ");
    $stmt->execute([$seatId]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Error clearing seat: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to clear seat']);
}
?> 