<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Enable error logging
error_log("[REGISTER] Starting registration process");

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Method not allowed');
}

// Get POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$plus_one = isset($_POST['plus_one']);

error_log("[REGISTER] Registration attempt for email: " . $email);

// Validate input
if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    error_log("[REGISTER] Registration failed: Empty fields");
    header('Location: ../register.php?error=' . urlencode('Please fill in all fields'));
    exit();
}

if (!isValidEmail($email)) {
    error_log("[REGISTER] Registration failed: Invalid email format - " . $email);
    header('Location: ../register.php?error=' . urlencode('Invalid email format'));
    exit();
}

if (!isValidPassword($password)) {
    error_log("[REGISTER] Registration failed: Invalid password length");
    header('Location: ../register.php?error=' . urlencode('Password must be at least 8 characters long'));
    exit();
}

if ($password !== $confirm_password) {
    error_log("[REGISTER] Registration failed: Passwords do not match");
    header('Location: ../register.php?error=' . urlencode('Passwords do not match'));
    exit();
}

// Debug output
error_log("[REGISTER] Database connection status: " . ($pdo ? "Connected" : "Not connected"));

// Check if email exists in approved_emails table
error_log("[REGISTER] Checking if email is approved: " . $email);
try {
    // Debug output for database connection
    error_log("[REGISTER] Database connection status: " . ($pdo ? "Connected" : "Not connected"));
    
    // First verify the approved_emails table exists
    $tableCheck = $pdo->query("SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_name = 'approved_emails'
    )")->fetchColumn();
    
    error_log("[REGISTER] approved_emails table exists: " . ($tableCheck ? "Yes" : "No"));
    
    if (!$tableCheck) {
        error_log("[REGISTER] Error: approved_emails table does not exist");
        header('Location: ../register.php?error=' . urlencode('Registration is currently unavailable. Please contact the administrator.'));
        exit();
    }
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM approved_emails WHERE email = ?");
    $stmt->execute([$email]);
    $isApproved = $stmt->fetchColumn() > 0;
    error_log("[REGISTER] Email approval check result: " . ($isApproved ? "Approved" : "Not approved"));

    if (!$isApproved) {
        error_log("[REGISTER] Registration rejected - email not approved: " . $email);
        header('Location: ../register.php?error=' . urlencode('This email is not authorized to register. Please contact the event organizer.'));
        exit();
    }
} catch (PDOException $e) {
    error_log("[REGISTER] Database error checking approved emails: " . $e->getMessage());
    error_log("[REGISTER] Stack trace: " . $e->getTraceAsString());
    header('Location: ../register.php?error=' . urlencode('An error occurred. Please try again later.'));
    exit();
}

// Check if email already exists in users table
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $emailExists = $stmt->fetchColumn() > 0;

    if ($emailExists) {
        error_log("[REGISTER] Registration failed: Email already exists - " . $email);
        header('Location: ../register.php?error=' . urlencode('This email is already registered. Please log in instead.'));
        exit();
    }
} catch (PDOException $e) {
    error_log("[REGISTER] Database error checking existing users: " . $e->getMessage());
    error_log("[REGISTER] Stack trace: " . $e->getTraceAsString());
    header('Location: ../register.php?error=' . urlencode('An error occurred. Please try again later.'));
    exit();
}

// Attempt registration
error_log("[REGISTER] Attempting to register user: " . $email);
$result = registerUser($name, $email, $password, $plus_one);

if ($result['success']) {
    error_log("[REGISTER] Registration successful for: " . $email);
    header('Location: ../index.php');
} else {
    error_log("[REGISTER] Registration failed: " . $result['message']);
    header('Location: ../register.php?error=' . urlencode($result['message']));
}
exit();
?> 