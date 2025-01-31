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

// Get venue parameter
$venue = isset($_GET['venue']) ? $_GET['venue'] : 'venue1';
if (!in_array($venue, ['venue1', 'venue2'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid venue']);
    exit();
}

$seatId = (int)$_POST['seat_id'];
$occupied = (int)$_POST['occupied'];

try {
    $pdo = new PDO("sqlite:../database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin transaction
    $pdo->beginTransaction();

    // Check if seat is already taken by someone else
    $stmt = $pdo->prepare("SELECT user_id FROM seats WHERE venue = ? AND seat_id = ? AND occupied = 1");
    $stmt->execute([$venue, $seatId]);
    $existingSeat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingSeat && $existingSeat['user_id'] !== $user['id'] && $occupied) {
        $pdo->rollBack();
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'Seat is already taken']);
        exit();
    }

    // Check if user has seats in a different venue
    if ($occupied) {
        $stmt = $pdo->prepare("SELECT DISTINCT venue FROM seats WHERE user_id = ? AND occupied = 1 AND venue != ?");
        $stmt->execute([$user['id'], $venue]);
        $otherVenue = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($otherVenue) {
            $pdo->rollBack();
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'You already have seats selected in a different venue']);
            exit();
        }
    }

    // Check if user has already selected maximum seats in this venue
    if ($occupied) {
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM seats WHERE venue = ? AND user_id = ? AND occupied = 1");
        $stmt->execute([$venue, $user['id']]);
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
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO seats (venue, seat_id, user_id, occupied) VALUES (?, ?, ?, ?)");
    $stmt->execute([$venue, $seatId, $user['id'], $occupied]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?> 