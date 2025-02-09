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

    // Get current plus_one status and seat information
    $stmt = $pdo->prepare("
        SELECT 
            u.plus_one,
            array_agg(s.seat_id ORDER BY s.seat_id DESC) FILTER (WHERE s.occupied = true) as seat_ids,
            COUNT(s.seat_id) FILTER (WHERE s.occupied = true) as seat_count
        FROM users u
        LEFT JOIN seats s ON u.id = s.user_id
        WHERE u.id = ?
        GROUP BY u.id, u.plus_one
    ");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit();
    }

    // If turning off plus_one and user has 2 seats, clear only the most recently selected seat
    if ($user['plus_one'] && $user['seat_count'] > 1) {
        // Convert PostgreSQL array to PHP array
        $seatIds = substr($user['seat_ids'], 1, -1); // Remove { and }
        $seatIds = explode(',', $seatIds);
        $lastSeatId = $seatIds[0]; // Get the most recent seat (ordered DESC above)
        
        $stmt = $pdo->prepare("UPDATE seats SET occupied = false WHERE user_id = ? AND seat_id = ?");
        $stmt->execute([$userId, $lastSeatId]);
    }

    // Toggle plus_one status
    $stmt = $pdo->prepare("UPDATE users SET plus_one = NOT plus_one WHERE id = ?");
    $stmt->execute([$userId]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Database error in toggle_plus_one.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?> 