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
    // Get approved emails that don't have corresponding user accounts
    $stmt = $pdo->query("
        SELECT ae.email, ae.created_at
        FROM approved_emails ae
        LEFT JOIN users u ON ae.email = u.email
        WHERE u.id IS NULL
        ORDER BY ae.created_at DESC
    ");
    
    $pendingEmails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($pendingEmails);
} catch (PDOException $e) {
    error_log("Error getting pending registrations: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?> 