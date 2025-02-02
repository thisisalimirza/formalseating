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

try {
    // Get all occupied seats
    $stmt = $pdo->prepare("
        SELECT seat_id, user_id 
        FROM seats 
        WHERE occupied = true
    ");
    $stmt->execute();
    $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($seats);
} catch (PDOException $e) {
    error_log("Database error in get_seats.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 