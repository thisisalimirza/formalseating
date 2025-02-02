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
    <nav class="bg-white shadow fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-6 mb-2 sm:mb-0">
                    <h1 class="text-xl font-bold text-gray-900">UCHC Formal 2025</h1>
                    <p class="text-gray-600 text-sm sm:border-l sm:border-gray-300 sm:pl-6">Welcome, <?php echo htmlspecialchars($user['name']); ?></p>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <?php if ($user['is_admin']): ?>
                    <a href="admin.php" class="flex-1 sm:flex-initial bg-blue-500 hover:bg-blue-600 text-white px-4 sm:px-6 py-2 rounded text-center text-sm font-medium">Admin Panel</a>
                    <?php endif; ?>
                    <a href="api/logout.php" class="flex-1 sm:flex-initial bg-red-500 hover:bg-red-600 text-white px-4 sm:px-6 py-2 rounded text-center text-sm font-medium">Sign out</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container mx-auto px-4 pt-32 pb-4">
        <!-- Seat selection section -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2">Select Your Seat</h2>
            <p class="text-gray-600 text-base mb-1">Click on an available seat to select it.</p>
            <p class="text-gray-600 text-base">You can select up to 2 seats.</p>
        </div>

        <!-- Legend and stats -->
        <div class="bg-white shadow rounded-lg p-4 mb-4">
            <div class="flex flex-col gap-4">
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-gray-200 rounded-full mr-2"></span>
                        <span class="text-sm">Available</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span>
                        <span class="text-sm">Your Selection</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                        <span class="text-sm">Occupied</span>
                    </div>
                </div>
                <div class="text-sm text-gray-600 text-center border-t pt-3">
                    Tables: 45 | Seats per table: 10
                </div>
            </div>
        </div>

        <!-- Seating map -->
        <div class="bg-white shadow rounded-lg p-4">
            <div id="seating-map" class="relative mx-auto bg-gray-50 rounded-lg p-4">
                <!-- Tables and seats will be dynamically added here by JavaScript -->
            </div>
        </div>
    </main>

    <!-- Toast notification -->
    <div id="toast" class="fixed bottom-4 right-4 transform transition-transform duration-300 translate-y-full z-50">
        <div class="flex items-center p-4 mb-4 text-sm rounded-lg shadow-lg min-w-[300px]" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg me-3">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"></svg>
            </div>
            <span id="toast-message" class="flex-1"></span>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex items-center justify-center h-8 w-8 text-gray-500 hover:text-gray-900" onclick="hideToast()">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
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

        // Enhanced toast notification system
        function showToast(message, type = 'info') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const icon = toast.querySelector('svg');
            const alert = toast.querySelector('[role="alert"]');
            
            // Configure based on type
            switch(type) {
                case 'error':
                    alert.className = 'flex items-center p-4 mb-4 text-red-800 bg-red-50 rounded-lg shadow-lg min-w-[300px]';
                    icon.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 1-1 1 1 0 0 1-1 1Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>';
                    break;
                case 'success':
                    alert.className = 'flex items-center p-4 mb-4 text-green-800 bg-green-50 rounded-lg shadow-lg min-w-[300px]';
                    icon.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>';
                    break;
                case 'warning':
                    alert.className = 'flex items-center p-4 mb-4 text-yellow-800 bg-yellow-50 rounded-lg shadow-lg min-w-[300px]';
                    icon.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 1-1 1 1 0 0 1-1 1Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>';
                    break;
                default:
                    alert.className = 'flex items-center p-4 mb-4 text-blue-800 bg-blue-50 rounded-lg shadow-lg min-w-[300px]';
                    icon.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>';
            }
            
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-full');
            
            // Auto-hide after duration unless it's an error
            if (type !== 'error') {
                setTimeout(hideToast, 5000);
            }
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('translate-y-full');
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

        // Enhanced seat click handler
        async function handleSeatClick(seatId) {
            const seat = document.querySelector(`[data-seat-id="${seatId}"]`);
            const isSelected = selectedSeats.includes(seatId);
            const isOccupied = occupiedSeats[seatId] && occupiedSeats[seatId] !== userId;

            if (isOccupied) {
                showToast('This seat is already taken by another attendee', 'error');
                return;
            }

            if (!isSelected && selectedSeats.length >= maxSeats) {
                const message = maxSeats === 1 
                    ? 'You can only select 1 seat. To select more seats, contact an admin to enable plus one.'
                    : 'You can only select 2 seats with your plus one option.';
                showToast(message, 'error');
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

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to update seat');
                }

                if (isSelected) {
                    selectedSeats = selectedSeats.filter(id => id !== seatId);
                    seat.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                    seat.classList.add('bg-gray-200', 'hover:bg-gray-300');
                    delete occupiedSeats[seatId];
                    showToast('Seat unselected successfully', 'success');
                } else {
                    selectedSeats.push(seatId);
                    seat.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                    seat.classList.add('bg-blue-500', 'hover:bg-blue-600');
                    occupiedSeats[seatId] = userId;
                    showToast('Seat selected successfully', 'success');
                }
            } catch (error) {
                console.error('Error updating seat:', error);
                showToast(error.message || 'Failed to update seat. Please try again.', 'error');
            }
        }

        // Enhanced seat status loading
        async function loadSeatStatus() {
            try {
                const response = await fetch('api/get_seats.php');
                if (!response.ok) {
                    throw new Error('Failed to load seats');
                }
                const seats = await response.json();

                occupiedSeats = {};
                selectedSeats = [];

                seats.forEach(seat => {
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
            } catch (error) {
                console.error('Error loading seats:', error);
                showToast('Failed to load seat status. Please refresh the page.', 'error');
            }
        }

        // Add error handling for resize observer
        let resizeTimeout;
        const resizeObserver = new ResizeObserver(entries => {
            try {
                for (const entry of entries) {
                    if (entry.target === seatingMap) {
                        clearTimeout(resizeTimeout);
                        resizeTimeout = setTimeout(() => {
                            createSeatingLayout();
                            loadSeatStatus();
                        }, 250);
                    }
                }
            } catch (error) {
                console.error('Error handling resize:', error);
                showToast('Failed to update layout. Please refresh the page.', 'error');
            }
        });

        try {
            resizeObserver.observe(seatingMap);
        } catch (error) {
            console.error('Failed to initialize resize observer:', error);
        }

        // Initialize with error handling
        try {
            createSeatingLayout();
            loadSeatStatus();
        } catch (error) {
            console.error('Error initializing seating map:', error);
            showToast('Failed to initialize seating map. Please refresh the page.', 'error');
        }
    </script>
</body>
</html> 