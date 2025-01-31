<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

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

// Validate input
if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    header('Location: ../register.php?error=' . urlencode('Please fill in all fields'));
    exit();
}

if (!isValidEmail($email)) {
    header('Location: ../register.php?error=' . urlencode('Invalid email format'));
    exit();
}

if (!isValidPassword($password)) {
    header('Location: ../register.php?error=' . urlencode('Password must be at least 8 characters long'));
    exit();
}

if ($password !== $confirm_password) {
    header('Location: ../register.php?error=' . urlencode('Passwords do not match'));
    exit();
}

// Attempt registration
$result = registerUser($name, $email, $password, $plus_one);

if ($result['success']) {
    header('Location: ../index.php');
} else {
    header('Location: ../register.php?error=' . urlencode($result['message']));
}
exit();
?> 