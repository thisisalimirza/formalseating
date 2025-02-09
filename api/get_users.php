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
    $dbUrl = parse_url(getenv("DATABASE_URL"));
    $pdo = new PDO(
        "pgsql:" . sprintf(
            "host=%s;port=%s;user=%s;password=%s;dbname=%s",
            $dbUrl["host"],
            $dbUrl["port"],
            $dbUrl["user"],
            $dbUrl["pass"],
            ltrim($dbUrl["path"], "/")
        )
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get users with their seat information
    $stmt = $pdo->query("
        SELECT 
            u.id,
            u.name,
            u.email,
            u.plus_one,
            array_agg(s.seat_id ORDER BY s.seat_id) FILTER (WHERE s.seat_id IS NOT NULL) as seats,
            array_agg(s.table_id ORDER BY s.seat_id) FILTER (WHERE s.table_id IS NOT NULL) as table_ids,
            array_agg(s.seat_number ORDER BY s.seat_id) FILTER (WHERE s.seat_number IS NOT NULL) as seat_numbers
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
            // Convert PostgreSQL array to PHP array
            $seats = preg_match('/^\{(.*)\}$/', $user['seats'], $matches) ? $matches[1] : '';
            $tableIds = preg_match('/^\{(.*)\}$/', $user['table_ids'], $matches) ? $matches[1] : '';
            $seatNumbers = preg_match('/^\{(.*)\}$/', $user['seat_numbers'], $matches) ? $matches[1] : '';
            
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
                $user['seats'] = [];
            }
        } else {
            $user['seats'] = [];
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