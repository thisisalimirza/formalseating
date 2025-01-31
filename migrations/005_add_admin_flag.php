<?php
require_once __DIR__ . '/../includes/config.php';

try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/../database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin transaction
    $pdo->beginTransaction();

    // Create temporary table with new schema
    $pdo->exec("CREATE TABLE IF NOT EXISTS users_new (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        plus_one INTEGER DEFAULT 0,
        is_admin INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Copy data from old table to new table
    $pdo->exec("INSERT OR IGNORE INTO users_new (id, name, email, password, plus_one, created_at)
                SELECT id, name, email, password, plus_one, created_at 
                FROM users");

    // Drop old table
    $pdo->exec("DROP TABLE IF EXISTS users");

    // Rename new table to users
    $pdo->exec("ALTER TABLE users_new RENAME TO users");

    // Add settings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        key TEXT UNIQUE NOT NULL,
        value TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Insert default settings
    $pdo->exec("INSERT OR IGNORE INTO settings (key, value) VALUES ('show_occupied_names', '0')");

    // Commit transaction
    $pdo->commit();

    echo "Migration completed successfully\n";
} catch (PDOException $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Migration failed: " . $e->getMessage() . "\n";
}
?> 