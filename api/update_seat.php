<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Check if user is authenticated
if (!isAuthenticated()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Get the current user
$user = getCurrentUser();

// Validate input parameters
if (!isset($_POST['seat_id']) || !isset($_POST['occupied'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit();
}

$seatId = (int)$_POST['seat_id'];
$occupied = (int)$_POST['occupied'];

// Calculate table and seat numbers
$tableId = floor(($seatId - 1) / 10) + 1;
$seatNumber = (($seatId - 1) % 10) + 1;

// Validate seat ID
if ($seatId < 1 || $seatId > 450) { // 45 tables * 10 seats
    http_response_code(400);
    echo json_encode(['error' => 'Invalid seat ID']);
    exit();
}

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Check if seat is already taken by someone else
    $stmt = $pdo->prepare("SELECT user_id FROM seats WHERE seat_id = ? AND occupied = true");
    $stmt->execute([$seatId]);
    $existingSeat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingSeat && $existingSeat['user_id'] !== $user['id'] && $occupied) {
        $pdo->rollBack();
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'Seat is already taken']);
        exit();
    }

    // Check if user has already selected maximum seats
    if ($occupied) {
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM seats WHERE user_id = ? AND occupied = true");
        $stmt->execute([$user['id']]);
        $seatCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        $maxSeats = $user['plus_one'] ? 2 : 1;
        if ($seatCount >= $maxSeats) {
            $pdo->rollBack();
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Maximum seats already selected']);
            exit();
        }
    }

    // Update or insert seat record
    $stmt = $pdo->prepare("
        INSERT INTO seats (seat_id, table_id, seat_number, user_id, occupied) 
        VALUES (?, ?, ?, ?, ?) 
        ON CONFLICT (seat_id) 
        DO UPDATE SET user_id = EXCLUDED.user_id, occupied = EXCLUDED.occupied
    ");
    $stmt->execute([$seatId, $tableId, $seatNumber, $user['id'], $occupied]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Database error in update_seat.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?> 