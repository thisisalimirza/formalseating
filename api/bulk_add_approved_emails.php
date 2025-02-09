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

// Get emails from POST data
$emails = json_decode(file_get_contents('php://input'), true);

if (!is_array($emails)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input format']);
    exit();
}

try {
    // Begin transaction
    $pdo->beginTransaction();
    
    $successCount = 0;
    $duplicateCount = 0;
    $invalidCount = 0;
    
    // Prepare statement for checking existing emails
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM approved_emails WHERE email = ?");
    
    // Prepare statement for inserting new emails
    $insertStmt = $pdo->prepare("INSERT INTO approved_emails (email) VALUES (?)");
    
    foreach ($emails as $email) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $invalidCount++;
            continue;
        }
        
        // Check if email already exists
        $checkStmt->execute([$email]);
        if ($checkStmt->fetchColumn() > 0) {
            $duplicateCount++;
            continue;
        }
        
        // Add email to approved list
        $insertStmt->execute([$email]);
        $successCount++;
    }
    
    // Commit transaction
    $pdo->commit();
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'stats' => [
            'total' => count($emails),
            'added' => $successCount,
            'duplicates' => $duplicateCount,
            'invalid' => $invalidCount
        ]
    ]);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} 