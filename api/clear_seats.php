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

// Get the current admin user
$admin = getCurrentUser();

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

    // Get current seats for the user before clearing
    $stmt = $pdo->prepare("
        SELECT seat_id, table_id 
        FROM seats 
        WHERE user_id = ? AND occupied = true
    ");
    $stmt->execute([$userId]);
    $seatsToBeCleared = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Clear all seats for the user
    $stmt = $pdo->prepare("
        UPDATE seats 
        SET occupied = false 
        WHERE user_id = ? AND occupied = true
    ");
    $stmt->execute([$userId]);

    // Log each cleared seat in the audit log
    $stmt = $pdo->prepare("
        INSERT INTO seat_audit_log 
        (user_id, seat_id, table_id, action_type, previous_user_id, performed_by_id, is_admin_action)
        VALUES (?, ?, ?, 'admin_clear', ?, ?, true)
    ");

    foreach ($seatsToBeCleared as $seat) {
        $stmt->execute([
            $userId,
            $seat['seat_id'],
            $seat['table_id'],
            $userId,
            $admin['id']
        ]);
    }

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