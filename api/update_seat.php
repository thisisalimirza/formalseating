<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

// Check authentication
if (!isAuthenticated()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'You must be logged in to select seats']);
    exit();
}

$user = getCurrentUser();

// Validate input
if (!isset($_POST['seat_id']) || !isset($_POST['occupied'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
    exit();
}

$seatId = filter_var($_POST['seat_id'], FILTER_VALIDATE_INT);
$isSelecting = $_POST['occupied'] === '1';
$occupied = $isSelecting ? 'true' : 'false';

if ($seatId === false) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid seat ID']);
    exit();
}

try {
    // Start transaction
    $pdo->beginTransaction();

    // Check if seat exists and is available
    $stmt = $pdo->prepare("SELECT occupied, user_id FROM seats WHERE seat_id = ?");
    $stmt->execute([$seatId]);
    $seat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$seat) {
        throw new Exception('Seat not found');
    }

    if ($isSelecting) {
        // Trying to select a seat
        if ($seat['occupied'] && $seat['user_id'] !== $user['id']) {
            throw new Exception('This seat is already taken by another user');
        }

        // Check if user has reached their seat limit
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM seats WHERE user_id = ? AND occupied = true");
        $stmt->execute([$user['id']]);
        $currentSeats = $stmt->fetchColumn();

        $maxSeats = $user['plus_one'] ? 2 : 1;
        if ($currentSeats >= $maxSeats && $seatId !== $seat['seat_id']) {
            throw new Exception($maxSeats === 1 
                ? 'You can only select 1 seat. Contact an admin to enable plus one.'
                : 'You can only select 2 seats with your plus one option.');
        }
    } else {
        // Trying to unselect a seat
        if (!$seat['occupied'] || $seat['user_id'] !== $user['id']) {
            throw new Exception('You cannot unselect this seat');
        }
    }

    // Update seat
    $stmt = $pdo->prepare("
        UPDATE seats 
        SET occupied = ?::boolean, user_id = ? 
        WHERE seat_id = ?
    ");
    $stmt->execute([$occupied, $isSelecting ? $user['id'] : null, $seatId]);

    $pdo->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error occurred. Please try again.']);
    error_log("Database error in update_seat.php: " . $e->getMessage());
}
?> 