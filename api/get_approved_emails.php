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
    error_log("Fetching approved emails...");
    $stmt = $pdo->query("SELECT email FROM approved_emails ORDER BY email");
    $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);
    error_log("Found " . count($emails) . " approved emails");
    
    header('Content-Type: application/json');
    echo json_encode($emails);
} catch (PDOException $e) {
    error_log("Database error in get_approved_emails.php: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} 