<?php
// Database configuration
$databaseUrl = getenv('DATABASE_URL');
$dbConfig = parse_url($databaseUrl);

// Application settings
define('APP_URL', 'https://seating-app-1738294124-e7b13f1dc901.herokuapp.com');  // Heroku app URL
define('APP_ENV', getenv('APP_ENV'));     // Environment from Heroku
define('APP_DEBUG', false);               // Disable debug in production

// Security
define('SESSION_LIFETIME', 3600);         // Session lifetime in seconds
define('CSRF_TOKEN_SECRET', getenv('CSRF_TOKEN_SECRET') ?: 'default-secret-key'); // CSRF protection key

// Error reporting
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    // Log errors instead of displaying them
    ini_set('log_errors', 1);
    ini_set('error_log', 'php://stderr');
}

// Create database connection
try {
    $dsn = sprintf(
        "pgsql:host=%s;port=%d;dbname=%s",
        $dbConfig['host'],
        isset($dbConfig['port']) ? $dbConfig['port'] : 5432,
        ltrim($dbConfig['path'], '/')
    );
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Could not connect to the database. Please try again later.");
}

// Enable error logging for debugging
error_log("Database connection established successfully");
?> 