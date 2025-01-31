<?php
// Database configuration
define('DB_HOST', getenv('DB_HOST'));     // Database host from Heroku
define('DB_NAME', getenv('DB_NAME'));     // Database name from Heroku
define('DB_USER', getenv('DB_USER'));     // Database username from Heroku
define('DB_PASS', getenv('DB_PASSWORD')); // Database password from Heroku

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
    $dsn = "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Could not connect to the database. Please try again later.");
}
?> 