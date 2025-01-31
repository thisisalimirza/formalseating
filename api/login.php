<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Method not allowed');
}

// Get POST data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validate input
if (empty($email) || empty($password)) {
    header('Location: ../login.php?error=' . urlencode('Please fill in all fields'));
    exit();
}

if (!isValidEmail($email)) {
    header('Location: ../login.php?error=' . urlencode('Invalid email format'));
    exit();
}

// Attempt login
$result = loginUser($email, $password);

if ($result['success']) {
    header('Location: ../index.php');
} else {
    header('Location: ../login.php?error=' . urlencode($result['message']));
}
exit();
?> 