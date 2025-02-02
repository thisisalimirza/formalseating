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
    $stmt = $pdo->query("SELECT email FROM approved_emails ORDER BY email");
    $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    header('Content-Type: application/json');
    echo json_encode($emails);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} 