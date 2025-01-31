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

    // Get users with their venue information
    $stmt = $pdo->query("
        SELECT 
            u.id,
            u.name,
            u.email,
            u.plus_one,
            s.venue
        FROM users u
        LEFT JOIN (
            SELECT DISTINCT user_id, venue
            FROM seats
            WHERE occupied = 1
        ) s ON u.id = s.user_id
        ORDER BY u.name
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 