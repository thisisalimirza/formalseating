<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Check if user is authenticated and is admin
if (!isAuthenticated() || !getCurrentUser()['is_admin']) {
    header('Location: index.php');
    exit();
}

$user = getCurrentUser();

// Get current settings
try {
    // Get current settings
    $stmt = $pdo->query("SELECT * FROM settings");
    $settings = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['key']] = $row['value'];
    }

    // Get user statistics
    $stmt = $pdo->query("
        SELECT 
            COUNT(*) as total_users,
            SUM(CASE WHEN plus_one = true THEN 1 ELSE 0 END) as plus_one_count
        FROM users
    ");
    $userStats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get seat statistics
    $stmt = $pdo->query("
        SELECT 
            COUNT(*) as occupied_seats,
            COUNT(DISTINCT user_id) as unique_users
        FROM seats 
        WHERE occupied = true
    ");
    $seatStats = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Medical School Formal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        @media print {
            /* Hide non-essential elements when printing */
            nav, 
            button,
            .stats-card,
            .settings-card,
            .user-management {
                display: none !important;
            }

            /* Show only the table assignments section */
            .table-assignments {
                display: block !important;
                page-break-inside: avoid;
            }

            /* Reset background colors and shadows for better printing */
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Ensure table headers print on each page */
            thead {
                display: table-header-group;
            }

            /* Add a title for the printed page */
            .table-assignments::before {
                content: "Medical School Formal - Table Assignments";
                display: block;
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
                text-align: center;
            }

            /* Improve table layout for printing */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            th, td {
                border: 1px solid #ddd !important;
                padding: 8px !important;
                text-align: left !important;
            }

            th {
                background-color: #f8f9fa !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-gray-900">Admin Panel</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 mr-4">Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
                    <a href="index.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 mr-2">
                        Back to Seating Map
                    </a>
                    <a href="api/logout.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                        Sign out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Settings -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Settings</h2>
            <div class="space-y-4">
                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" id="show-names" class="sr-only" <?php echo ($settings['show_occupied_names'] ?? '0') === '1' ? 'checked' : ''; ?>>
                            <div class="block bg-gray-200 w-14 h-8 rounded-full transition-colors duration-200"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-200" style="transform: <?php echo ($settings['show_occupied_names'] ?? '0') === '1' ? 'translateX(24px)' : 'translateX(0)'; ?>"></div>
                        </div>
                        <div class="ml-3 text-gray-700">Show names on occupied seats</div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- User Statistics -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">User Statistics</h2>
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Users</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo $userStats['total_users']; ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Users with Plus One</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo $userStats['plus_one_count']; ?></dd>
                    </div>
                </dl>
            </div>

            <!-- Seat Statistics -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Seat Statistics</h2>
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Occupied Seats</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo $seatStats['occupied_seats']; ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Unique Users with Seats</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo $seatStats['unique_users']; ?></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- User Management -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">User Management</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plus One</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Selected Seats</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="user-list">
                        <!-- User rows will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table Assignments Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Table Assignments</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Table</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seated Attendees</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available Seats</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        // Get table assignments
                        try {
                            // First create a temporary table with numbers 1-45
                            $pdo->exec("
                                CREATE TEMPORARY TABLE IF NOT EXISTS table_numbers (
                                    table_num INT PRIMARY KEY
                                );
                                
                                TRUNCATE table_numbers;
                                
                                INSERT INTO table_numbers (table_num)
                                WITH RECURSIVE numbers AS (
                                    SELECT 1 as n
                                    UNION ALL
                                    SELECT n + 1 FROM numbers WHERE n < 45
                                )
                                SELECT n FROM numbers;
                            ");

                            $stmt = $pdo->query("
                                SELECT 
                                    tn.table_num,
                                    COALESCE(
                                        GROUP_CONCAT(
                                            DISTINCT u.name 
                                            ORDER BY s.seat_id 
                                            SEPARATOR ', '
                                        ),
                                        ''
                                    ) as seated_users,
                                    COUNT(s.seat_id) as occupied_seats
                                FROM table_numbers tn
                                LEFT JOIN (
                                    SELECT 
                                        FLOOR((seat_id - 1) / 10) + 1 as table_num,
                                        seat_id,
                                        user_id
                                    FROM seats
                                ) s ON tn.table_num = s.table_num
                                LEFT JOIN users u ON s.user_id = u.id
                                GROUP BY tn.table_num
                                ORDER BY tn.table_num;
                            ");
                            
                            $tableAssignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($tableAssignments as $table) {
                                echo "<tr>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>Table {$table['table_num']}</td>";
                                echo "<td class='px-6 py-4 text-sm text-gray-500'>" . ($table['seated_users'] ? htmlspecialchars($table['seated_users']) : 'No attendees') . "</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . (10 - $table['occupied_seats']) . " seats available</td>";
                                echo "</tr>";
                            }

                            // Clean up temporary table
                            $pdo->exec("DROP TEMPORARY TABLE IF EXISTS table_numbers");
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='3' class='px-6 py-4 text-sm text-red-500'>Error loading table assignments: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Print Button -->
            <div class="mt-4 flex justify-end">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Table Assignments
                </button>
            </div>
        </div>
    </main>

    <script>
        // Toggle show names setting
        document.getElementById('show-names').addEventListener('change', async function(e) {
            const toggle = this;
            const dot = toggle.parentElement.querySelector('.dot');
            
            try {
                const response = await fetch('api/update_settings.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `key=show_occupied_names&value=${toggle.checked ? '1' : '0'}`
                });

                const data = await response.json();
                if (!response.ok || !data.success) {
                    throw new Error(data.error || 'Failed to update setting');
                }

                // Update the toggle visual state
                if (toggle.checked) {
                    toggle.parentElement.querySelector('.block').classList.add('bg-blue-600');
                    dot.style.transform = 'translateX(24px)';
                } else {
                    toggle.parentElement.querySelector('.block').classList.remove('bg-blue-600');
                    dot.style.transform = 'translateX(0)';
                }

                // Reload the page after a short delay to show the animation
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            } catch (error) {
                console.error('Error updating setting:', error);
                alert('Failed to update setting. Please try again.');
                // Revert the toggle state
                toggle.checked = !toggle.checked;
            }
        });

        // Load user list
        async function loadUsers() {
            try {
                const response = await fetch('api/get_users.php');
                if (!response.ok) throw new Error('Failed to load users');
                
                const users = await response.json();
                const tbody = document.getElementById('user-list');
                tbody.innerHTML = users.map(user => `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${user.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.plus_one ? 'Yes' : 'No'}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            ${user.seats ? user.seats.map(seat => `
                                <div class="mb-1">${seat}</div>
                            `).join('') : 'None'}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="togglePlusOne(${user.id})" class="text-blue-600 hover:text-blue-900 mr-2">
                                Toggle Plus One
                            </button>
                            <button onclick="clearSeats(${user.id})" class="text-red-600 hover:text-red-900">
                                Clear Seats
                            </button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error loading users:', error);
            }
        }

        // Toggle plus one status
        async function togglePlusOne(userId) {
            try {
                const response = await fetch('api/toggle_plus_one.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `user_id=${userId}`
                });

                if (!response.ok) throw new Error('Failed to toggle plus one status');
                
                // Reload user list
                loadUsers();
            } catch (error) {
                console.error('Error toggling plus one:', error);
                alert('Failed to update plus one status. Please try again.');
            }
        }

        // Clear user's seats
        async function clearSeats(userId) {
            if (!confirm('Are you sure you want to clear this user\'s seats?')) return;

            try {
                const response = await fetch('api/clear_seats.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `user_id=${userId}`
                });

                if (!response.ok) throw new Error('Failed to clear seats');
                
                // Reload user list
                loadUsers();
            } catch (error) {
                console.error('Error clearing seats:', error);
                alert('Failed to clear seats. Please try again.');
            }
        }

        // Initialize
        loadUsers();
    </script>
</body>
</html> 