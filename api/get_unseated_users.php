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

try {
    // Query to get users and their seat counts
    $stmt = $pdo->query("
        WITH user_seats AS (
            SELECT 
                u.id,
                u.name,
                u.email,
                u.plus_one,
                COUNT(s.seat_id) as selected_seats
            FROM users u
            LEFT JOIN seats s ON u.id = s.user_id AND s.occupied = true
            GROUP BY u.id, u.name, u.email, u.plus_one
        )
        SELECT 
            id,
            name,
            email,
            plus_one,
            selected_seats
        FROM user_seats
        WHERE (plus_one = true AND selected_seats < 2)
           OR (plus_one = false AND selected_seats < 1)
        ORDER BY name ASC
    ");

    $unseatedUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the results
    header('Content-Type: application/json');
    echo json_encode($unseatedUsers);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} 