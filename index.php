<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session and load dependencies
session_start();
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Log environment for debugging
error_log("Environment: " . getenv('APP_ENV'));
error_log("Database URL: " . (getenv('DATABASE_URL') ? 'Set' : 'Not Set'));

// Redirect to login if not authenticated
if (!isAuthenticated()) {
    header('Location: login.php');
    exit();
}

$user = getCurrentUser();

// Get current settings
try {
    // Use the PDO instance from config.php
    $stmt = $pdo->query("SELECT * FROM settings");
    $settings = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['key']] = $row['value'];
    }
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seating Map - Medical School Formal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-gray-900">Medical School Formal</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 mr-4">Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
                    <?php if ($user['is_admin']): ?>
                    <a href="admin.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 mr-2">
                        Admin Panel
                    </a>
                    <?php endif; ?>
                    <a href="api/logout.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                        Sign out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Seating map header -->
        <div class="px-4 sm:px-0 mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Select Your Seat</h2>
            <p class="mt-1 text-sm text-gray-600">
                Click on an available seat to select it. 
                <?php if ($user['plus_one']): ?>
                    You can select up to 2 seats.
                <?php else: ?>
                    You can select 1 seat.
                <?php endif; ?>
            </p>
        </div>

        <!-- Venue tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex" aria-label="Venues">
                    <button id="venue1-tab" class="venue-tab active w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Venue 1
                    </button>
                    <button id="venue2-tab" class="venue-tab w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Venue 2
                    </button>
                </nav>
            </div>
        </div>

        <!-- Seating map -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between mb-6">
                <div class="flex space-x-4 text-sm">
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-gray-200 rounded-full mr-2"></span>
                        Available
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span>
                        Your Selection
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                        Occupied
                    </div>
                </div>
                <div class="text-sm text-gray-600">
                    Tables: <span id="table-count">32</span> | 
                    Seats per table: <span id="seats-per-table">10</span>
                </div>
            </div>

            <div id="seating-map" class="relative mx-auto bg-gray-50 rounded-lg p-8">
                <!-- Tables will be dynamically added here by JavaScript -->
            </div>
        </div>
    </main>

    <!-- Toast notification -->
    <div id="toast" class="fixed bottom-4 right-4 transform transition-transform duration-300 translate-y-full">
        <div class="bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg">
            <span id="toast-message"></span>
        </div>
    </div>

    <script>
        // Configuration
        const userId = <?php echo json_encode($user['id']); ?>;
        const maxSeats = <?php echo $user['plus_one'] ? 2 : 1; ?>;
        const showOccupiedNames = <?php echo json_encode(($settings['show_occupied_names'] ?? '0') === '1'); ?>;
        
        const venueConfigs = {
            venue1: {
                name: "Venue 1",
                tables: 32,
                seatsPerTable: 10,
                tableRadius: 45,
                seatRadius: 10,
                seatSpacing: 1.6,
                tableSpacing: 1.3,
                minPadding: 100
            },
            venue2: {
                name: "Venue 2",
                tables: 13,
                seatsPerTable: 10,
                tableRadius: 45,
                seatRadius: 10,
                seatSpacing: 1.6,
                tableSpacing: 1.3,
                minPadding: 100
            }
        };

        let currentVenue = 'venue1';
        let config = venueConfigs[currentVenue];
        
        // State
        let selectedSeats = {
            venue1: [],
            venue2: []
        };
        let occupiedSeats = {
            venue1: {},
            venue2: {}
        };

        // DOM Elements
        const seatingMap = document.getElementById('seating-map');
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        const venue1Tab = document.getElementById('venue1-tab');
        const venue2Tab = document.getElementById('venue2-tab');

        // Handle venue tab clicks
        function switchVenue(venueName) {
            currentVenue = venueName;
            config = venueConfigs[venueName];
            
            // Update UI
            document.querySelectorAll('.venue-tab').forEach(tab => {
                tab.classList.remove('active', 'border-blue-500', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });
            
            document.getElementById(`${venueName}-tab`).classList.add('active', 'border-blue-500', 'text-blue-600');
            document.getElementById(`${venueName}-tab`).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            
            // Rebuild seating map
            createSeatingLayout();
            loadSeatStatus();
        }

        venue1Tab.addEventListener('click', () => switchVenue('venue1'));
        venue2Tab.addEventListener('click', () => switchVenue('venue2'));

        // Show toast message
        function showToast(message, duration = 3000) {
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-full');
            setTimeout(() => {
                toast.classList.add('translate-y-full');
            }, duration);
        }

        // Create seat element
        function createSeat(seatId, angle, tableX, tableY) {
            const seatDistance = (config.tableRadius + config.seatRadius * config.seatSpacing);
            const x = Math.round(tableX + seatDistance * Math.cos(angle));
            const y = Math.round(tableY + seatDistance * Math.sin(angle));

            const seat = document.createElement('button');
            seat.className = 'absolute rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none seat-btn';
            seat.style.cssText = `
                width: ${config.seatRadius * 2}px;
                height: ${config.seatRadius * 2}px;
                left: ${x}px;
                top: ${y}px;
            `;
            seat.dataset.seatId = `${currentVenue}-${seatId}`;
            seat.setAttribute('aria-label', `Seat ${seatId}`);

            if (showOccupiedNames) {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip opacity-0 invisible absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-sm text-white bg-gray-900 rounded whitespace-nowrap transition-all duration-200';
                seat.appendChild(tooltip);

                seat.addEventListener('mouseenter', async () => {
                    if (occupiedSeats[currentVenue][seatId] && occupiedSeats[currentVenue][seatId] !== userId) {
                        try {
                            const response = await fetch(`api/get_user.php?id=${occupiedSeats[currentVenue][seatId]}`);
                            if (!response.ok) throw new Error('Failed to get user info');
                            const user = await response.json();
                            tooltip.textContent = user.name;
                            tooltip.classList.remove('opacity-0', 'invisible');
                        } catch (error) {
                            console.error('Error getting user info:', error);
                        }
                    }
                });

                seat.addEventListener('mouseleave', () => {
                    tooltip.classList.add('opacity-0', 'invisible');
                });
            }

            seat.addEventListener('click', () => handleSeatClick(seatId));
            return seat;
        }

        // Create table element
        function createTable(tableIndex, centerX, centerY) {
            const table = document.createElement('div');
            table.className = 'table rounded-full';
            table.style.cssText = `
                width: ${config.tableRadius * 2}px;
                height: ${config.tableRadius * 2}px;
                left: ${Math.round(centerX)}px;
                top: ${Math.round(centerY)}px;
            `;
            
            // Add table number
            const tableNumber = document.createElement('div');
            tableNumber.className = 'absolute inset-0 flex items-center justify-center text-gray-600 font-medium select-none';
            tableNumber.textContent = `Table ${tableIndex + 1}`;
            table.appendChild(tableNumber);
            
            return table;
        }

        // Calculate required dimensions
        function calculateMapDimensions() {
            const cols = 5; // Increased number of columns for better layout
            const rows = Math.ceil(config.tables / cols);
            
            // Calculate space needed for each table including its seats
            const totalTableRadius = config.tableRadius + (config.seatRadius * 2 * config.seatSpacing);
            const minTableSpace = Math.round(totalTableRadius * 2 * config.tableSpacing);
            
            // Calculate minimum required width and height
            const minWidth = (minTableSpace * cols) + (config.minPadding * 2);
            const minHeight = (minTableSpace * rows) + (config.minPadding * 2);
            
            return { minWidth, minHeight, cols, rows };
        }

        // Create seating layout
        function createSeatingLayout() {
            const { minWidth, minHeight, cols, rows } = calculateMapDimensions();
            
            // Set minimum dimensions on the container
            seatingMap.style.minWidth = `${minWidth}px`;
            seatingMap.style.minHeight = `${minHeight}px`;
            
            // Calculate spacing
            const mapRect = seatingMap.getBoundingClientRect();
            const availableWidth = mapRect.width - (config.minPadding * 2);
            const availableHeight = mapRect.height - (config.minPadding * 2);
            
            const colSpacing = Math.round(availableWidth / cols);
            const rowSpacing = Math.round(availableHeight / rows);
            
            // Clear existing layout
            seatingMap.innerHTML = '';
            
            // Create tables and seats
            for (let i = 0; i < config.tables; i++) {
                const row = Math.floor(i / cols);
                const col = i % cols;
                
                const centerX = Math.round(config.minPadding + colSpacing * (col + 0.5));
                const centerY = Math.round(config.minPadding + rowSpacing * (row + 0.5));
                
                // Add table
                const table = createTable(i, centerX, centerY);
                seatingMap.appendChild(table);
                
                // Add seats around the table
                for (let j = 0; j < config.seatsPerTable; j++) {
                    const angle = (j * 2 * Math.PI) / config.seatsPerTable;
                    const seatId = i * config.seatsPerTable + j + 1;
                    const seat = createSeat(seatId, angle, centerX, centerY);
                    seatingMap.appendChild(seat);
                }
            }

            // Update displayed counts
            document.getElementById('table-count').textContent = config.tables;
            document.getElementById('seats-per-table').textContent = config.seatsPerTable;
        }

        // Handle seat selection
        function handleSeatClick(seatId) {
            if (occupiedSeats[currentVenue][seatId] && occupiedSeats[currentVenue][seatId] !== userId) {
                showToast('This seat is already taken');
                return;
            }

            const seatIndex = selectedSeats[currentVenue].indexOf(seatId);
            const seatElement = document.querySelector(`[data-seat-id="${currentVenue}-${seatId}"]`);

            if (seatIndex === -1) {
                if (selectedSeats[currentVenue].length >= maxSeats) {
                    showToast(`You can only select ${maxSeats} seat${maxSeats > 1 ? 's' : ''}`);
                    return;
                }
                selectedSeats[currentVenue].push(seatId);
                seatElement.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                seatElement.classList.add('bg-blue-500', 'hover:bg-blue-600');
                updateSeat(seatId, true);
            } else {
                selectedSeats[currentVenue].splice(seatIndex, 1);
                seatElement.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                seatElement.classList.add('bg-gray-200', 'hover:bg-gray-300');
                updateSeat(seatId, false);
            }
        }

        // Update seat status in the database
        async function updateSeat(seatId, occupied) {
            try {
                const response = await fetch(`/api/update_seat.php?venue=${currentVenue}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `seat_id=${seatId}&occupied=${occupied ? 1 : 0}`,
                });

                if (!response.ok) {
                    throw new Error('Failed to update seat');
                }

                const result = await response.json();
                if (!result.success) {
                    throw new Error(result.message);
                }

                if (occupied) {
                    occupiedSeats[currentVenue][seatId] = userId;
                } else {
                    delete occupiedSeats[currentVenue][seatId];
                }

                showToast(occupied ? 'Seat selected successfully' : 'Seat unselected successfully');
            } catch (error) {
                console.error('Error updating seat:', error);
                showToast('Failed to update seat. Please try again.');
                
                // Revert the UI change
                const seatElement = document.querySelector(`[data-seat-id="${currentVenue}-${seatId}"]`);
                if (occupied) {
                    selectedSeats[currentVenue] = selectedSeats[currentVenue].filter(id => id !== seatId);
                    seatElement.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                    seatElement.classList.add('bg-gray-200', 'hover:bg-gray-300');
                } else {
                    selectedSeats[currentVenue].push(seatId);
                    seatElement.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                    seatElement.classList.add('bg-blue-500', 'hover:bg-blue-600');
                }
            }
        }

        // Load initial seat status
        async function loadSeatStatus() {
            try {
                const response = await fetch(`/api/get_seats.php?venue=${currentVenue}`);
                if (!response.ok) throw new Error('Failed to load seat status');
                
                const seats = await response.json();
                occupiedSeats[currentVenue] = seats;

                // Update UI for occupied seats
                Object.entries(seats).forEach(([seatId, seatUserId]) => {
                    const seatElement = document.querySelector(`[data-seat-id="${currentVenue}-${seatId}"]`);
                    if (seatElement) {
                        if (seatUserId === userId) {
                            selectedSeats[currentVenue].push(parseInt(seatId));
                            seatElement.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                            seatElement.classList.add('bg-blue-500', 'hover:bg-blue-600');
                        } else {
                            seatElement.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                            seatElement.classList.add('bg-red-500');
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading seat status:', error);
                showToast('Failed to load seat status. Please refresh the page.');
            }
        }

        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                createSeatingLayout();
                loadSeatStatus();
            }, 250);
        });

        // Initialize
        window.addEventListener('load', () => {
            switchVenue('venue1');
        });
    </script>
</body>
</html> 