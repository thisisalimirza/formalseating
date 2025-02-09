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
    // Get audit log with user details
    $stmt = $pdo->query("
        SELECT 
            al.id,
            al.seat_id,
            al.table_id,
            al.action_type,
            al.is_admin_action,
            al.created_at,
            -- User who the action was performed on
            u.name as user_name,
            u.email as user_email,
            -- Previous user if seat was reassigned
            pu.name as previous_user_name,
            pu.email as previous_user_email,
            -- User who performed the action
            pa.name as performed_by_name,
            pa.email as performed_by_email
        FROM seat_audit_log al
        LEFT JOIN users u ON al.user_id = u.id
        LEFT JOIN users pu ON al.previous_user_id = pu.id
        LEFT JOIN users pa ON al.performed_by_id = pa.id
        ORDER BY al.created_at DESC
        LIMIT 1000
    ");
    
    $auditLog = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format dates and add readable descriptions
    foreach ($auditLog as &$entry) {
        $entry['created_at'] = date('Y-m-d H:i:s', strtotime($entry['created_at']));
        
        // Create readable description
        $description = '';
        switch ($entry['action_type']) {
            case 'select':
                $description = sprintf(
                    '%s selected seat %d at table %d',
                    $entry['user_name'],
                    $entry['seat_id'] % 10 ?: 10,
                    $entry['table_id']
                );
                break;
            case 'deselect':
                $description = sprintf(
                    '%s removed their selection from seat %d at table %d',
                    $entry['user_name'],
                    $entry['seat_id'] % 10 ?: 10,
                    $entry['table_id']
                );
                break;
            case 'admin_clear':
                $description = sprintf(
                    'Admin (%s) cleared seat %d at table %d',
                    $entry['performed_by_name'],
                    $entry['seat_id'] % 10 ?: 10,
                    $entry['table_id']
                );
                break;
            default:
                $description = sprintf(
                    'Seat %d at table %d was modified',
                    $entry['seat_id'] % 10 ?: 10,
                    $entry['table_id']
                );
        }
        $entry['description'] = $description;
    }
    
    header('Content-Type: application/json');
    echo json_encode($auditLog);
} catch (PDOException $e) {
    error_log("Database error in get_seat_audit_log.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
} 