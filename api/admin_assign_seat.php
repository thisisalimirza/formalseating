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
if (!isset($_POST['seat_id']) || !isset($_POST['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required parameters']);
    exit();
}

$seatId = intval($_POST['seat_id']);
$userId = intval($_POST['user_id']);

try {
    // Start transaction
    $pdo->beginTransaction();

    // Check if seat exists and is not occupied
    $stmt = $pdo->prepare("SELECT occupied FROM seats WHERE id = ?");
    $stmt->execute([$seatId]);
    $seat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$seat) {
        throw new Exception('Invalid seat');
    }

    if ($seat['occupied']) {
        throw new Exception('Seat is already taken');
    }

    // Check if user exists and has available seats
    $stmt = $pdo->prepare("
        SELECT 
            u.plus_one,
            COUNT(s.id) as current_seats
        FROM users u
        LEFT JOIN seats s ON s.user_id = u.id AND s.occupied = true
        WHERE u.id = ?
        GROUP BY u.id, u.plus_one
    ");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception('User not found');
    }

    $maxSeats = $user['plus_one'] ? 2 : 1;
    if ($user['current_seats'] >= $maxSeats) {
        throw new Exception('User has already selected maximum number of seats');
    }

    // Assign seat to user
    $stmt = $pdo->prepare("
        UPDATE seats 
        SET occupied = true, user_id = ? 
        WHERE id = ?
    ");
    $stmt->execute([$userId, $seatId]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?> 