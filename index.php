<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/auth.php';

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
    <main class="container mx-auto px-4 py-4">
        <!-- Header section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div class="flex flex-col">
                <h1 class="text-3xl font-bold mb-1">Medical School Formal</h1>
                <p class="text-gray-600">Welcome, <?php echo htmlspecialchars($user['name']); ?></p>
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="admin.php" class="flex-1 sm:flex-none bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded text-center">Admin Panel</a>
                <a href="logout.php" class="flex-1 sm:flex-none bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded text-center">Sign out</a>
            </div>
        </div>

        <!-- Seat selection section -->
        <div class="mb-8">
            <h2 class="text-4xl font-bold mb-2">Select Your Seat</h2>
            <p class="text-gray-600 text-lg">Click on an available seat to select it.</p>
            <p class="text-gray-600 text-lg">You can select up to 2 seats.</p>
        </div>

        <!-- Legend and stats -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex flex-wrap justify-center sm:justify-start gap-4 w-full sm:w-auto">
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
                <div class="text-sm text-gray-600 whitespace-nowrap">
                    Tables: 45 | Seats per table: 10
                </div>
            </div>
        </div>

        <!-- Seating map -->
        <div class="bg-white shadow rounded-lg p-6">
            <div id="seating-map" class="relative mx-auto bg-gray-50 rounded-lg p-8">
                <!-- Tables and seats will be dynamically added here by JavaScript -->
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
        
        const config = {
            tables: 45,
            seatsPerTable: 10,
            tableRadius: 45,
            seatRadius: 10,
            seatSpacing: 1.6,
            tableSpacing: 1.3,
            minPadding: 20
        };
        
        // State
        let selectedSeats = [];
        let occupiedSeats = {};

        // DOM Elements
        const seatingMap = document.getElementById('seating-map');
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        // Show toast message
        function showToast(message, duration = 3000) {
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-full');
            setTimeout(() => {
                toast.classList.add('translate-y-full');
            }, duration);
        }

        // Create seat element
        function createSeat(tableIndex, seatIndex, angle, tableX, tableY) {
            const seatId = (tableIndex * config.seatsPerTable) + seatIndex + 1;
            const seatDistance = (config.tableRadius + config.seatRadius * config.seatSpacing);
            const x = Math.round(tableX + seatDistance * Math.cos(angle));
            const y = Math.round(tableY + seatDistance * Math.sin(angle));

            const seatContainer = document.createElement('div');
            seatContainer.className = 'absolute';
            seatContainer.style.cssText = `
                left: ${x}px;
                top: ${y}px;
                transform: translate(-50%, -50%);
                z-index: 0;
            `;

            const seat = document.createElement('button');
            seat.className = 'rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none seat-btn transition-colors duration-200';
            seat.style.cssText = `
                width: ${config.seatRadius * 2}px;
                height: ${config.seatRadius * 2}px;
            `;
            seat.dataset.seatId = seatId;
            seat.dataset.tableId = tableIndex + 1;
            seat.setAttribute('aria-label', `Table ${tableIndex + 1}, Seat ${seatIndex + 1}`);

            if (showOccupiedNames) {
                const tooltipContainer = document.createElement('div');
                tooltipContainer.className = 'absolute w-0 h-0 overflow-visible';
                tooltipContainer.style.cssText = `
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%, -50%);
                    z-index: 9999;
                    display: none;
                `;

                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip absolute transform -translate-x-1/2 px-2 py-1 text-sm text-white bg-gray-900 rounded whitespace-nowrap transition-all duration-200 pointer-events-none';
                tooltip.style.cssText = `
                    bottom: calc(100% + 8px);
                    left: 50%;
                    z-index: 9999;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                `;

                // Add tooltip arrow
                const arrow = document.createElement('div');
                arrow.className = 'absolute left-1/2 bottom-0 transform -translate-x-1/2 translate-y-full';
                arrow.style.cssText = `
                    width: 0;
                    height: 0;
                    border-left: 6px solid transparent;
                    border-right: 6px solid transparent;
                    border-top: 6px solid #111827;
                `;
                tooltip.appendChild(arrow);
                tooltipContainer.appendChild(tooltip);
                seatContainer.appendChild(tooltipContainer);

                seat.addEventListener('mouseenter', async () => {
                    const occupantId = occupiedSeats[seatId];
                    if (occupantId && occupantId !== userId) {
                        try {
                            const response = await fetch(`api/get_user.php?id=${occupantId}`);
                            const data = await response.json();
                            
                            if (!response.ok) {
                                throw new Error(data.error || 'Failed to get user info');
                            }
                            
                            tooltip.textContent = data.name;
                            tooltip.appendChild(arrow);
                            tooltipContainer.style.display = 'block';
                            tooltip.style.opacity = '1';
                            tooltip.style.visibility = 'visible';
                        } catch (error) {
                            console.error('Error getting user info:', error);
                            tooltip.textContent = 'Unable to load name';
                            tooltip.appendChild(arrow);
                            tooltipContainer.style.display = 'block';
                            tooltip.style.opacity = '1';
                            tooltip.style.visibility = 'visible';
                        }
                    }
                });

                seat.addEventListener('mouseleave', () => {
                    tooltipContainer.style.display = 'none';
                    tooltip.style.opacity = '0';
                    tooltip.style.visibility = 'hidden';
                });
            }

            seat.addEventListener('click', () => handleSeatClick(seatId));
            seatContainer.appendChild(seat);
            return seatContainer;
        }

        // Create table element
        function createTable(tableIndex, centerX, centerY) {
            const table = document.createElement('div');
            table.className = 'absolute rounded-full bg-white border-2 border-gray-300';
            table.style.cssText = `
                width: ${config.tableRadius * 2}px;
                height: ${config.tableRadius * 2}px;
                left: ${Math.round(centerX - config.tableRadius)}px;
                top: ${Math.round(centerY - config.tableRadius)}px;
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
            // Get container width
            const containerWidth = seatingMap.clientWidth;
            
            // Determine if we're on mobile
            const isMobile = window.innerWidth <= 768;
            
            // Calculate optimal table size based on container width
            // For mobile, we want 2 columns
            const maxTablesPerRow = isMobile ? 2 : Math.max(6, Math.floor(containerWidth / 200));
            const cols = Math.min(maxTablesPerRow, Math.ceil(Math.sqrt(config.tables)));
            const rows = Math.ceil(config.tables / cols);
            
            // Calculate table and seat sizes based on available space
            const availableWidth = containerWidth - (config.minPadding * 2);
            const spacePerTable = Math.floor(availableWidth / cols);
            
            // Update table and seat sizes based on available space
            // Adjusted sizes for 2-column mobile layout
            if (isMobile) {
                config.tableRadius = Math.max(20, Math.min(32, Math.floor(spacePerTable / 3)));
                config.seatRadius = Math.max(4, Math.min(7, Math.floor(config.tableRadius / 4)));
                config.seatSpacing = 1.3; // Slightly more spacing for 2 columns
                config.tableSpacing = 1.15;
                config.minPadding = 12; // Reduced padding for mobile
            } else {
                config.tableRadius = Math.max(25, Math.min(45, Math.floor(spacePerTable / 4)));
                config.seatRadius = Math.max(5, Math.min(10, Math.floor(config.tableRadius / 4)));
                config.seatSpacing = 1.6;
                config.tableSpacing = 1.3;
                config.minPadding = 20;
            }
            
            // Calculate total space needed for each table including its seats
            const totalTableRadius = config.tableRadius + (config.seatRadius * 2 * config.seatSpacing);
            const minTableSpace = Math.round(totalTableRadius * 2 * config.tableSpacing);
            
            // Calculate minimum required width and height
            const minWidth = (minTableSpace * cols) + (config.minPadding * 2);
            const minHeight = (minTableSpace * rows) + (config.minPadding * 2);
            
            return { minWidth, minHeight, cols, rows, spacePerTable };
        }

        // Create seating layout
        function createSeatingLayout() {
            const { minWidth, minHeight, cols, rows, spacePerTable } = calculateMapDimensions();
            
            // Clear existing layout
            seatingMap.innerHTML = '';
            
            // Set container minimum height
            seatingMap.style.minHeight = `${minHeight}px`;
            
            // Calculate spacing between table centers
            const colSpacing = Math.floor(spacePerTable);
            const rowSpacing = Math.floor(spacePerTable);
            
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
                    const seat = createSeat(i, j, angle, centerX, centerY);
                    seatingMap.appendChild(seat);
                }
            }
        }

        // Handle seat click
        async function handleSeatClick(seatId) {
            const seat = document.querySelector(`[data-seat-id="${seatId}"]`);
            const isSelected = selectedSeats.includes(seatId);
            const isOccupied = occupiedSeats[seatId] && occupiedSeats[seatId] !== userId;

            if (isOccupied) {
                showToast('This seat is already taken');
                return;
            }

            if (!isSelected && selectedSeats.length >= maxSeats) {
                showToast(`You can only select ${maxSeats} seat${maxSeats > 1 ? 's' : ''}`);
                return;
            }

            try {
                const response = await fetch('api/update_seat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `seat_id=${seatId}&occupied=${!isSelected ? 1 : 0}`,
                });

                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.message || 'Failed to update seat');
                }

                if (isSelected) {
                    selectedSeats = selectedSeats.filter(id => id !== seatId);
                    seat.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                    seat.classList.add('bg-gray-200', 'hover:bg-gray-300');
                    delete occupiedSeats[seatId];
                } else {
                    selectedSeats.push(seatId);
                    seat.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                    seat.classList.add('bg-blue-500', 'hover:bg-blue-600');
                    occupiedSeats[seatId] = userId;
                }
            } catch (error) {
                showToast(error.message);
            }
        }

        // Load initial seat status
        async function loadSeatStatus() {
            try {
                const response = await fetch('api/get_seats.php');
                if (!response.ok) throw new Error('Failed to load seats');
                const seats = await response.json();

                occupiedSeats = {};
                selectedSeats = [];

                console.log('Loaded seats:', seats); // Debug log

                seats.forEach(seat => {
                    // Convert string IDs to integers
                    const seatId = parseInt(seat.seat_id);
                    const occupantId = parseInt(seat.user_id);
                    
                    occupiedSeats[seatId] = occupantId;
                    const seatElement = document.querySelector(`button[data-seat-id="${seatId}"]`);
                    
                    if (seatElement) {
                        if (occupantId === userId) {
                            selectedSeats.push(seatId);
                            seatElement.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                            seatElement.classList.add('bg-blue-500', 'hover:bg-blue-600');
                        } else {
                            seatElement.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                            seatElement.classList.add('bg-red-500', 'hover:bg-red-600');
                        }
                    }
                });

                console.log('Occupied seats:', occupiedSeats); // Debug log
            } catch (error) {
                console.error('Error loading seats:', error);
                showToast('Failed to load seat status');
            }
        }

        // Add resize observer for more responsive updates
        const resizeObserver = new ResizeObserver(entries => {
            for (const entry of entries) {
                if (entry.target === seatingMap) {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        createSeatingLayout();
                        loadSeatStatus();
                    }, 250);
                }
            }
        });

        resizeObserver.observe(seatingMap);

        // Initialize
        createSeatingLayout();
        loadSeatStatus();
    </script>
</body>
</html> 