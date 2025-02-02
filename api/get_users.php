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
            ARRAY_AGG(s.seat_id ORDER BY s.seat_id) FILTER (WHERE s.seat_id IS NOT NULL) as seats,
            ARRAY_AGG(s.table_id ORDER BY s.seat_id) FILTER (WHERE s.table_id IS NOT NULL) as table_ids,
            ARRAY_AGG(s.seat_number ORDER BY s.seat_id) FILTER (WHERE s.seat_number IS NOT NULL) as seat_numbers
        FROM users u
        LEFT JOIN (
            SELECT user_id, seat_id, table_id, seat_number
            FROM seats
            WHERE occupied = true
        ) s ON u.id = s.user_id
        GROUP BY u.id, u.name, u.email, u.plus_one
        ORDER BY u.name
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Process the seat information for display
    foreach ($users as &$user) {
        if ($user['seats'] !== null) {
            // Convert PostgreSQL array string to PHP array
            $seats = trim($user['seats'], '{}');
            $tableIds = trim($user['table_ids'], '{}');
            $seatNumbers = trim($user['seat_numbers'], '{}');
            
            if ($seats) {
                $seatIds = explode(',', $seats);
                $tableIds = explode(',', $tableIds);
                $seatNumbers = explode(',', $seatNumbers);
                
                // Format as "Table X, Seat Y"
                $formattedSeats = array_map(function($tableId, $seatNumber) {
                    return "Table $tableId, Seat $seatNumber";
                }, $tableIds, $seatNumbers);
                
                $user['seats'] = $formattedSeats;
            } else {
                $user['seats'] = null;
            }
        }
        
        // Remove unnecessary fields
        unset($user['table_ids']);
        unset($user['seat_numbers']);
    }
    
    echo json_encode($users);
} catch (PDOException $e) {
    error_log("Database error in get_users.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 