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

// Get venue parameter
$venue = isset($_GET['venue']) ? $_GET['venue'] : 'venue1';
if (!in_array($venue, ['venue1', 'venue2'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid venue']);
    exit();
}

try {
    $pdo = new PDO("sqlite:../database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get all occupied seats for the specific venue
    $stmt = $pdo->prepare("SELECT seat_id, user_id FROM seats WHERE venue = ? AND occupied = 1");
    $stmt->execute([$venue]);
    
    $occupiedSeats = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $occupiedSeats[$row['seat_id']] = $row['user_id'];
    }
    
    echo json_encode($occupiedSeats);
} catch (PDOException $e) {
    error_log("Error fetching seats: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?> 