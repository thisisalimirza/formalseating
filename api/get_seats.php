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
    // Get all occupied seats with their user IDs
    $stmt = $pdo->query("
        SELECT 
            seat_id,
            user_id,
            table_id,
            seat_number
        FROM seats 
        WHERE occupied = true
        ORDER BY seat_id
    ");
    
    $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($seats);
} catch (PDOException $e) {
    http_response_code(500);
    error_log("Error getting seats: " . $e->getMessage());
    echo json_encode(['error' => 'Database error']);
}
?> 