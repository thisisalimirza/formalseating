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
    <title>Admin Panel - UHC Formal 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        [x-cloak] { display: none !important; }
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
                content: "UCHC Formal 2025 - Table Assignments";
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
<body class="bg-gray-50 min-h-screen" x-data="{ currentSection: 'dashboard' }">
    <!-- Navigation -->
    <nav class="bg-white shadow fixed w-full z-10">
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

    <div class="flex h-screen pt-16">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-sm fixed h-full">
            <nav class="mt-5 px-2">
                <a @click.prevent="currentSection = 'dashboard'" href="#dashboard"
                    class="group flex items-center px-2 py-2 text-base font-medium rounded-md"
                    :class="currentSection === 'dashboard' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-chart-line mr-3 w-6"></i>
                    Dashboard
                </a>
                <a @click.prevent="currentSection = 'users'" href="#users"
                    class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md"
                    :class="currentSection === 'users' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-users mr-3 w-6"></i>
                    Attendee Management
                </a>
                <a @click.prevent="currentSection = 'registrations'" href="#registrations"
                    class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md"
                    :class="currentSection === 'registrations' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-user-plus mr-3 w-6"></i>
                    Registrations
                </a>
                <a @click.prevent="currentSection = 'seating'" href="#seating"
                    class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md"
                    :class="currentSection === 'seating' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-chair mr-3 w-6"></i>
                    Seating
                </a>
                <a @click.prevent="currentSection = 'settings'" href="#settings"
                    class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md"
                    :class="currentSection === 'settings' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'">
                    <i class="fas fa-cog mr-3 w-6"></i>
                    Settings
                </a>
            </nav>
        </div>

    <!-- Main content -->
        <div class="flex-1 pl-64">
            <main class="py-6 px-4 sm:px-6 lg:px-8">
                <!-- Dashboard Section -->
                <div x-show="currentSection === 'dashboard'" x-cloak>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h2>
                    
                    <!-- Registration Funnel -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Registration Funnel</h3>
                        <div class="relative">
                            <!-- Funnel Visualization -->
                            <div class="space-y-4">
                                <!-- Approved Emails -->
                                <div @click="currentSection = 'users'" class="bg-blue-50 rounded-lg p-4 relative cursor-pointer hover:bg-blue-100 transition-colors duration-200">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium text-blue-900">Approved Emails</h4>
                                            <p class="text-sm text-blue-700" id="approved-emails-count">Loading...</p>
                        </div>
                                        <div class="text-2xl font-bold text-blue-900" id="approved-emails-number">-</div>
                </div>
                                    <!-- Arrow -->
                                    <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2">
                                        <svg class="h-4 w-4 text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 16l-6-6h12l-6 6z"></path>
                                        </svg>
            </div>
        </div>

                                <!-- Registered Accounts -->
                                <div @click="currentSection = 'registrations'" class="bg-green-50 rounded-lg p-4 relative cursor-pointer hover:bg-green-100 transition-colors duration-200">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium text-green-900">Registered Accounts</h4>
                                            <p class="text-sm text-green-700" id="registered-accounts-count">Loading...</p>
                                        </div>
                                        <div class="text-2xl font-bold text-green-900" id="registered-accounts-number">-</div>
                                    </div>
                                    <!-- Arrow -->
                                    <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2">
                                        <svg class="h-4 w-4 text-green-200" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 16l-6-6h12l-6 6z"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Selected Seats -->
                                <div @click="currentSection = 'seating'" class="bg-purple-50 rounded-lg p-4 cursor-pointer hover:bg-purple-100 transition-colors duration-200">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium text-purple-900">Selected Seats</h4>
                                            <p class="text-sm text-purple-700" id="selected-seats-count">Loading...</p>
                                        </div>
                                        <div class="text-2xl font-bold text-purple-900" id="selected-seats-number">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- User Statistics -->
            <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">User Statistics</h3>
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
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Seat Statistics</h3>
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
        </div>

                <!-- User Management Section -->
                <div x-show="currentSection === 'users'" x-cloak>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Attendee Management</h2>
        <div class="bg-white shadow rounded-lg p-6">
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
                </div>

                <!-- Registrations Section -->
                <div x-show="currentSection === 'registrations'" x-cloak>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Registration Management</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Approved Emails -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Approved Emails</h3>
                            <div class="mb-4">
                                <form id="add-email-form" class="flex gap-2">
                                    <input type="email" id="new-email" placeholder="Enter email address" required
                                        class="flex-1 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        Add Email
                                    </button>
                                </form>
                                <a href="bulk_import_emails.php"
                                    class="mt-2 inline-flex w-full items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                                    <i class="fas fa-upload mr-2"></i>
                                    Bulk Import
                                </a>
                            </div>
                            <div class="overflow-y-auto max-h-[500px]">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50 sticky top-0">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="approved-emails-list" class="bg-white divide-y divide-gray-200">
                                        <!-- Approved emails will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pending Registrations -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Pending Registrations</h3>
                                <span id="pending-count" class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full"></span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">These emails have been approved but haven't registered an account yet.</p>
                            <div class="overflow-y-auto max-h-[500px]">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50 sticky top-0">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approved Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pending-registrations-list" class="bg-white divide-y divide-gray-200">
                                        <!-- Pending registrations will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seating Section -->
                <div x-show="currentSection === 'seating'" x-cloak>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Seating Management</h2>
                    
                    <!-- Users Without Seats -->
                    <div class="bg-white shadow rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Users Without Seats</h3>
                            <span id="unseated-count" class="bg-orange-100 text-orange-800 text-sm font-medium px-3 py-1 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Users who haven't selected all their available seats.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plus One</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Missing Seats</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="unseated-users-list" class="bg-white divide-y divide-gray-200">
                                    <!-- Users without seats will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Table Assignments -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Table Assignments</h3>
                            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Print Table Assignments
                            </button>
                        </div>
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
                    </div>
                </div>

                <!-- Settings Section -->
                <div x-show="currentSection === 'settings'" x-cloak>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Settings</h2>
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" id="show-names" class="sr-only" <?php echo ($settings['show_occupied_names'] ?? '0') === '1' ? 'checked' : ''; ?>>
                                        <div class="block bg-gray-200 w-14 h-8 rounded-full transition-colors duration-200"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-200" style="transform: <?php echo ($settings['show_occupied_names'] ?? '0') === '1' ? 'translateX(24px)' : 'translateX(0)'; ?>"></div>
                                    </div>
                                    <div class="ml-3 text-gray-700">Publicly display names of seated attendees</div>
                                </label>
                            </div>
                        </div>
            </div>
        </div>
    </main>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <button onclick="togglePlusOne(${user.id})" class="text-sm">
                                ${user.plus_one ? 'Yes' : 'No'}
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${user.seats.join('<br>')}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button onclick="togglePlusOne(${user.id})" class="text-blue-600 hover:text-blue-900">
                                Toggle Plus One
                            </button>
                            <button onclick="clearSeats(${user.id})" class="text-red-600 hover:text-red-900 ml-4">
                                Clear Seats
                            </button>
                            <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900 ml-4">
                                Delete User
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

                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.message || 'Failed to toggle plus one status');
                }
                
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                successMessage.textContent = 'Plus one status updated successfully';
                document.body.appendChild(successMessage);
                
                // Remove success message after 3 seconds
                setTimeout(() => {
                    successMessage.remove();
                }, 3000);
                
                // Reload user list to show updated status
                await loadUsers();
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

                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.message || 'Failed to clear seats');
                }
                
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                successMessage.textContent = 'Seats cleared successfully';
                document.body.appendChild(successMessage);
                
                // Remove success message after 3 seconds
                setTimeout(() => {
                    successMessage.remove();
                }, 3000);
                
                // Reload user list to show updated seats
                await loadUsers();
            } catch (error) {
                console.error('Error clearing seats:', error);
                alert('Failed to clear seats. Please try again.');
            }
        }

        // Load approved emails
        async function loadApprovedEmails() {
            try {
                const response = await fetch('api/get_approved_emails.php');
                if (!response.ok) throw new Error('Failed to load approved emails');
                
                const emails = await response.json();
                const tbody = document.getElementById('approved-emails-list');
                tbody.innerHTML = emails.map(email => `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="removeApprovedEmail('${email}')" class="text-red-600 hover:text-red-900">
                                Remove
                            </button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error loading approved emails:', error);
            }
        }

        // Add approved email
        document.getElementById('add-email-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const emailInput = document.getElementById('new-email');
            const email = emailInput.value;

            try {
                const response = await fetch('api/add_approved_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}`
                });

                if (!response.ok) throw new Error('Failed to add email');
                
                emailInput.value = '';
                // Update both lists
                await Promise.all([
                    loadApprovedEmails(),
                    loadPendingRegistrations(),
                    updateFunnelStats()
                ]);
                
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                successMessage.textContent = 'Email added successfully';
                document.body.appendChild(successMessage);
                
                // Remove success message after 3 seconds
                setTimeout(() => {
                    successMessage.remove();
                }, 3000);
            } catch (error) {
                console.error('Error adding email:', error);
                alert('Failed to add email. Please try again.');
            }
        });

        // Remove approved email
        async function removeApprovedEmail(email) {
            if (!confirm('Are you sure you want to remove this email?')) return;

            try {
                const response = await fetch('api/remove_approved_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}`
                });

                if (!response.ok) throw new Error('Failed to remove email');
                
                // Update all relevant lists and stats
                await Promise.all([
                    loadApprovedEmails(),
                    loadPendingRegistrations(),
                    updateFunnelStats()
                ]);
                
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                successMessage.textContent = 'Email approval removed successfully';
                document.body.appendChild(successMessage);
                
                // Remove success message after 3 seconds
                setTimeout(() => {
                    successMessage.remove();
                }, 3000);
            } catch (error) {
                console.error('Error removing email:', error);
                alert('Failed to remove email. Please try again.');
            }
        }

        // Load pending registrations
        async function loadPendingRegistrations() {
            try {
                const response = await fetch('api/get_pending_registrations.php');
                if (!response.ok) throw new Error('Failed to load pending registrations');
                
                const pendingEmails = await response.json();
                const tbody = document.getElementById('pending-registrations-list');
                const pendingCount = document.getElementById('pending-count');
                
                // Update the count badge
                pendingCount.textContent = `${pendingEmails.length} Pending`;
                
                tbody.innerHTML = pendingEmails.map(email => `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${email.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(email.created_at).toLocaleDateString()}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="removeApprovedEmail('${email.email}')" class="text-red-600 hover:text-red-900">
                                Remove Approval
                            </button>
                            <button onclick="resendInvite('${email.email}')" class="text-blue-600 hover:text-blue-900 ml-4">
                                Send Invite Email
                            </button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error loading pending registrations:', error);
            }
        }

        // Open default email client with pre-filled invite email
        function resendInvite(email) {
            const subject = "UCHC Formal 2025 - Seat Selection Registration";
            const body = `Hello,

You have been approved to register for seat selection for the UCHC Formal 2025.

Please visit the following link to create your account and select your seats:
${window.location.origin}

Best regards,
UCHC Formal Committee`;

            const mailtoLink = `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            window.location.href = mailtoLink;
        }

        // Load users without seats
        async function loadUnseatedUsers() {
            try {
                const response = await fetch('api/get_unseated_users.php');
                if (!response.ok) throw new Error('Failed to load unseated users');
                
                const users = await response.json();
                const tbody = document.getElementById('unseated-users-list');
                const unseatedCount = document.getElementById('unseated-count');
                
                // Update the count badge
                unseatedCount.textContent = `${users.length} Users`;
                
                tbody.innerHTML = users.map(user => {
                    const maxSeats = user.plus_one ? 2 : 1;
                    const missingSeats = maxSeats - user.selected_seats;
                    
                    return `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${user.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.plus_one ? 'Yes' : 'No'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${missingSeats} seat${missingSeats > 1 ? 's' : ''} to select
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="sendSeatReminder('${user.email}', ${missingSeats})" class="text-blue-600 hover:text-blue-900">
                                    Send Reminder
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            } catch (error) {
                console.error('Error loading unseated users:', error);
            }
        }

        // Send seat selection reminder email
        function sendSeatReminder(email, missingSeats) {
            const subject = "UCHC Formal 2025 - Seat Selection Reminder";
            const body = `Hello,

This is a reminder that you still need to select ${missingSeats} seat${missingSeats > 1 ? 's' : ''} for the UCHC Formal 2025.

Please visit the following link to select your seats:
${window.location.origin}

Best regards,
UCHC Formal Committee`;

            const mailtoLink = `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            window.location.href = mailtoLink;
        }

        // Add this to your existing JavaScript, after the other function definitions
        async function updateFunnelStats() {
            try {
                // Get approved emails count
                const approvedEmailsResponse = await fetch('api/get_approved_emails.php');
                const approvedEmails = await approvedEmailsResponse.json();
                const approvedEmailsCount = approvedEmails.length;
                
                // Get registered users count
                const usersResponse = await fetch('api/get_users.php');
                const users = await usersResponse.json();
                const registeredUsersCount = users.length;
                
                // Get selected seats count
                const seatsResponse = await fetch('api/get_seats.php');
                const seats = await seatsResponse.json();
                const selectedSeatsCount = seats.length;
                
                // Update the funnel visualization
                document.getElementById('approved-emails-number').textContent = approvedEmailsCount;
                document.getElementById('approved-emails-count').textContent = 
                    `${((registeredUsersCount / approvedEmailsCount) * 100).toFixed(1)}% conversion to registration`;
                
                document.getElementById('registered-accounts-number').textContent = registeredUsersCount;
                document.getElementById('registered-accounts-count').textContent = 
                    `${((selectedSeatsCount / (registeredUsersCount * 1.5)) * 100).toFixed(1)}% seat selection rate`;
                
                document.getElementById('selected-seats-number').textContent = selectedSeatsCount;
                document.getElementById('selected-seats-count').textContent = 
                    `${selectedSeatsCount} out of ${registeredUsersCount * 1.5} possible seats selected`;
                
            } catch (error) {
                console.error('Error updating funnel stats:', error);
            }
        }

        // Add this new function with the other JavaScript functions
        async function deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                return;
            }

            try {
                const response = await fetch('api/delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `user_id=${userId}`
                });

                const data = await response.json();
                if (data.success) {
                    loadUsers();
                    updateFunnelStats();
                } else {
                    throw new Error(data.error || 'Failed to delete user');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to delete user. Please try again.');
            }
        }

        // Initialize
        loadUsers();
        loadApprovedEmails();
        loadPendingRegistrations();
        loadUnseatedUsers();
        updateFunnelStats();
    </script>
</body>
</html> 