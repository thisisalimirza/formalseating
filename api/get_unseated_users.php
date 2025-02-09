<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Check if user is authenticated and is admin
if (!isAuthenticated() || !getCurrentUser()['is_admin']) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

try {
    // Get users who haven't selected all their seats
    $stmt = $pdo->query("
        WITH user_seats AS (
            SELECT 
                u.id,
                u.name,
                u.email,
                u.plus_one,
                COUNT(s.id) as selected_seats
            FROM users u
            LEFT JOIN seats s ON s.user_id = u.id AND s.occupied = true
            GROUP BY u.id, u.name, u.email, u.plus_one
        )
        SELECT 
            id,
            name,
            email,
            plus_one,
            selected_seats,
            CASE 
                WHEN plus_one THEN GREATEST(2 - selected_seats, 0)
                ELSE GREATEST(1 - selected_seats, 0)
            END as missing_seats
        FROM user_seats
        WHERE (plus_one = true AND selected_seats < 2)
           OR (plus_one = false AND selected_seats < 1)
        ORDER BY name ASC
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 