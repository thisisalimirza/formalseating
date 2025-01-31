<?php
// Database configuration
define('DB_HOST', 'localhost');     // Your database host
define('DB_NAME', 'seating_db');    // Your database name
define('DB_USER', 'username');      // Your database username
define('DB_PASS', 'password');      // Your database password

// Application settings
define('APP_URL', 'https://your-domain.com');  // Your application URL
define('APP_ENV', 'production');               // Environment (production/development)
define('APP_DEBUG', false);                    // Debug mode

// Security
define('SESSION_LIFETIME', 3600);              // Session lifetime in seconds
define('CSRF_TOKEN_SECRET', 'your-secret-key'); // CSRF protection key 