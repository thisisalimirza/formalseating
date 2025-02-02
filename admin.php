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
                            // Create a PHP array of table numbers
                            $tableNumbers = range(1, 45);
                            $placeholders = str_repeat('(?),', count($tableNumbers) - 1) . '(?)';
                            
                            // Drop the temporary table if it exists
                            $pdo->exec("DROP TABLE IF EXISTS table_numbers");
                            
                            // Create temporary table
                            $pdo->exec("
                                CREATE TEMPORARY TABLE table_numbers (
                                    table_num INT PRIMARY KEY
                                )
                            ");
                            
                            // Prepare and execute insert
                            $stmt = $pdo->prepare("INSERT INTO table_numbers (table_num) VALUES " . $placeholders);
                            $stmt->execute($tableNumbers);

                            // Query for table assignments with proper DISTINCT handling
                            $stmt = $pdo->query("
                                WITH seated_users AS (
                                    SELECT 
                                        FLOOR((s.seat_id - 1) / 10) + 1 as table_num,
                                        s.user_id,
                                        u.name as user_name,
                                        s.seat_id,
                                        u.plus_one,
                                        ROW_NUMBER() OVER (PARTITION BY u.id, FLOOR((s.seat_id - 1) / 10) + 1 ORDER BY s.seat_id) as seat_num
                                    FROM seats s
                                    JOIN users u ON s.user_id = u.id
                                    WHERE s.occupied = true
                                )
                                SELECT 
                                    tn.table_num,
                                    COALESCE(
                                        string_agg(
                                            CASE 
                                                WHEN su.plus_one AND su.seat_num = 2 THEN 
                                                    su.user_name || '''s +1'
                                                ELSE 
                                                    su.user_name
                                            END,
                                            ', '
                                            ORDER BY su.seat_id
                                        ),
                                        ''
                                    ) as seated_users,
                                    COUNT(su.user_name) as occupied_seats
                                FROM table_numbers tn
                                LEFT JOIN seated_users su ON tn.table_num = su.table_num
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

                            // Clean up temporary table - no need to check if exists
                            $pdo->exec("DROP TABLE table_numbers");
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
        // Enhanced toast notification system (same as index.php)
        function showToast(message, type = 'info') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const icon = toast.querySelector('svg');
            const alert = toast.querySelector('[role="alert"]');
            
            switch(type) {
                case 'error':
                    alert.className = 'flex items-center p-4 mb-4 text-red-800 bg-red-50 rounded-lg shadow-lg min-w-[300px]';
                    icon.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 1-1 1 1 0 0 1-1 1Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>';
                    break;
                case 'success':
                    alert.className = 'flex items-center p-4 mb-4 text-green-800 bg-green-50 rounded-lg shadow-lg min-w-[300px]';
                    icon.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>';
                    break;
                default:
                    alert.className = 'flex items-center p-4 mb-4 text-blue-800 bg-blue-50 rounded-lg shadow-lg min-w-[300px]';
                    icon.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>';
            }
            
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-full');
            
            if (type !== 'error') {
                setTimeout(hideToast, 5000);
            }
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('translate-y-full');
        }

        // Enhanced toggle plus one function
        async function togglePlusOne(userId) {
            try {
                const response = await fetch('api/toggle_plus_one.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `user_id=${userId}`
                });

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.error || 'Failed to toggle plus one status');
                }
                
                showToast('Plus one status updated successfully', 'success');
                await loadUsers();
            } catch (error) {
                console.error('Error toggling plus one:', error);
                showToast(error.message || 'Failed to update plus one status', 'error');
            }
        }

        // Enhanced clear seats function
        async function clearSeats(userId) {
            if (!confirm('Are you sure you want to clear all seats for this user? This action cannot be undone.')) {
                return;
            }

            try {
                const response = await fetch('api/clear_seats.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `user_id=${userId}`
                });

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.error || 'Failed to clear seats');
                }
                
                showToast('Seats cleared successfully', 'success');
                await loadUsers();
            } catch (error) {
                console.error('Error clearing seats:', error);
                showToast(error.message || 'Failed to clear seats', 'error');
            }
        }

        // Enhanced user list loading
        async function loadUsers() {
            try {
                const response = await fetch('api/get_users.php');
                if (!response.ok) {
                    throw new Error('Failed to load users');
                }
                
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
                            <button onclick="togglePlusOne(${user.id})" class="text-blue-600 hover:text-blue-900 mr-2 focus:outline-none focus:underline">
                                Toggle Plus One
                            </button>
                            <button onclick="clearSeats(${user.id})" class="text-red-600 hover:text-red-900 focus:outline-none focus:underline">
                                Clear Seats
                            </button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error loading users:', error);
                showToast('Failed to load user list. Please refresh the page.', 'error');
            }
        }

        // Enhanced settings toggle
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

                showToast('Setting updated successfully', 'success');

                // Reload the page after a short delay to show the animation
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } catch (error) {
                console.error('Error updating setting:', error);
                showToast('Failed to update setting', 'error');
                // Revert the toggle state
                toggle.checked = !toggle.checked;
            }
        });

        // Initialize
        try {
            loadUsers();
        } catch (error) {
            console.error('Error initializing admin panel:', error);
            showToast('Failed to initialize admin panel. Please refresh the page.', 'error');
        }
    </script>
</body>
</html> 