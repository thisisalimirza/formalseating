<?php
require_once __DIR__ . '/../includes/config.php';

try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/../database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if old table exists
    $tableExists = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='seats'")->fetch();

    if ($tableExists) {
        // Create temporary table with new schema
        $pdo->exec("CREATE TABLE seats_new (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            venue TEXT NOT NULL,
            seat_id INTEGER NOT NULL,
            user_id INTEGER NOT NULL,
            occupied INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(venue, seat_id)
        )");

        // Copy existing data to new table with default venue
        $pdo->exec("INSERT INTO seats_new (venue, seat_id, user_id, occupied, created_at)
                    SELECT 'venue1', seat_id, user_id, occupied, created_at
                    FROM seats");

        // Drop old table and rename new table
        $pdo->exec("DROP TABLE seats");
        $pdo->exec("ALTER TABLE seats_new RENAME TO seats");
    } else {
        // Create new table with venue support
        $pdo->exec("CREATE TABLE seats (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            venue TEXT NOT NULL,
            seat_id INTEGER NOT NULL,
            user_id INTEGER NOT NULL,
            occupied INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(venue, seat_id)
        )");
    }

    echo "Migration completed successfully\n";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
?> 