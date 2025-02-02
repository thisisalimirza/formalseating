<?php
require_once __DIR__ . '/../includes/config.php';

try {
    $dbUrl = parse_url(getenv("DATABASE_URL"));
    $pdo = new PDO(
        "pgsql:" . sprintf(
            "host=%s;port=%s;user=%s;password=%s;dbname=%s",
            $dbUrl["host"],
            $dbUrl["port"],
            $dbUrl["user"],
            $dbUrl["pass"],
            ltrim($dbUrl["path"], "/")
        )
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if table exists (PostgreSQL version)
    $tableExists = $pdo->query("SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_name = 'seats'
    )")->fetch(PDO::FETCH_COLUMN);

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