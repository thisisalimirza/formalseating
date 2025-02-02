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
    
    // Return success response
    http_response_code(200);
    echo json_encode($seats);
} catch (PDOException $e) {
    error_log("Database error in get_seats.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?> 