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
    $pdo = new PDO("sqlite:../database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get users with their seat information
    $stmt = $pdo->query("
        SELECT 
            u.id,
            u.name,
            u.email,
            u.plus_one,
            ARRAY_AGG(s.seat_id ORDER BY s.seat_id) FILTER (WHERE s.seat_id IS NOT NULL) as seats
        FROM users u
        LEFT JOIN (
            SELECT user_id, seat_id
            FROM seats
            WHERE occupied = true
        ) s ON u.id = s.user_id
        GROUP BY u.id, u.name, u.email, u.plus_one
        ORDER BY u.name
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convert string representation of array to actual array
    foreach ($users as &$user) {
        if ($user['seats'] !== null) {
            // Remove the curly braces and split the string
            $seats = trim($user['seats'], '{}');
            $user['seats'] = $seats ? explode(',', $seats) : null;
        }
    }
    
    echo json_encode($users);
} catch (PDOException $e) {
    error_log("Database error in get_users.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 