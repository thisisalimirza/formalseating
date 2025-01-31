<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is authenticated
 * @return bool
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current user data
 * @return array|null
 */
function getCurrentUser() {
    global $pdo;
    
    if (!isAuthenticated()) {
        return null;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, name, email, plus_one, is_admin FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching user: " . $e->getMessage());
        return null;
    }
}

/**
 * Login user
 * @param string $email
 * @param string $password
 * @return array Success status and message
 */
function loginUser($email, $password) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return ['success' => true, 'message' => 'Login successful'];
        }

        return ['success' => false, 'message' => 'Invalid email or password'];
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred during login'];
    }
}

/**
 * Register new user
 * @param string $name
 * @param string $email
 * @param string $password
 * @param bool $plus_one
 * @return array Success status and message
 */
function registerUser($name, $email, $password, $plus_one = false) {
    global $pdo;

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email already registered'];
        }

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, plus_one) VALUES (?, ?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$name, $email, $hashedPassword, $plus_one ? 1 : 0]);

        // Log user in after registration
        $_SESSION['user_id'] = $pdo->lastInsertId();
        
        return ['success' => true, 'message' => 'Registration successful'];
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred during registration'];
    }
}

/**
 * Logout user
 */
function logoutUser() {
    $_SESSION = array();
    session_destroy();
}

/**
 * Validate password
 * @param string $password
 * @return bool
 */
function isValidPassword($password) {
    return strlen($password) >= 8;
}

/**
 * Validate email
 * @param string $email
 * @return bool
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?> 