<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Get the current host
$host = $_SERVER['HTTP_HOST'];

// If on main domain (usesitr.com), show landing page
if ($host === 'usesitr.com') {
    include 'landing.php';
    exit();
}

// For subdomain (uconn.usesitr.com) or any other domain, continue with login check
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
    <title>Seating Map - UCHC Formal 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .sitr-gradient {
            background: linear-gradient(135deg, #10B981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-pattern {
            background-image: radial-gradient(#E5E7EB 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .hover-scale {
            transition: transform 0.2s ease;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
        .legend-item {
            transition: all 0.2s ease;
        }
        .legend-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed top-0 left-0 right-0 z-50 backdrop-blur-sm bg-white/95">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-8 mb-2 sm:mb-0">
                    <div class="flex items-center gap-3">
                        <h1 class="text-xl font-bold text-gray-900 tracking-tight">UCHC Formal 2025</h1>
                        <span class="hidden sm:block h-6 w-px bg-gray-200"></span>
                        <span class="sitr-gradient text-sm font-medium">Powered by Sitr</span>
                    </div>
                    <p class="text-gray-600 text-sm sm:border-l sm:border-gray-200 sm:pl-8">Welcome, <?php echo htmlspecialchars($user['name']); ?></p>
                </div>
                <div class="flex gap-3 w-full sm:w-auto">
                    <?php if ($user['is_admin']): ?>
                    <a href="admin.php" class="flex-1 sm:flex-initial bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg text-center text-sm font-medium transition-all duration-200 hover:shadow-lg">
                        <i class="fas fa-cog mr-2"></i>Admin Panel
                    </a>
                    <?php endif; ?>
                    <a href="api/logout.php" class="flex-1 sm:flex-initial border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-lg text-center text-sm font-medium transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container mx-auto px-4 pt-32 pb-8">
        <!-- Seat selection section -->
        <div class="mb-8 fade-in">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 flex items-center gap-3">
                <i class="fas fa-chair text-emerald-600"></i>
                Select Your Seat
            </h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                <p class="text-gray-600 text-base mb-2 flex items-center gap-2">
                    <i class="fas fa-info-circle text-emerald-600"></i>
                    Click on an available seat to select it.
                </p>
                <p class="text-gray-600 text-base flex items-center gap-2">
                    <i class="fas fa-user-plus text-emerald-600"></i>
                    You can select up to <?php echo $user['plus_one'] ? '2' : '1'; ?> seat<?php echo $user['plus_one'] ? 's' : ''; ?>.
                </p>
            </div>
        </div>

        <!-- Legend and stats -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-8 fade-in border border-gray-100">
            <div class="flex flex-col gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="legend-item flex items-center justify-center p-3 rounded-lg bg-gray-50 hover-scale">
                        <span class="w-4 h-4 bg-gray-200 rounded-full mr-3"></span>
                        <span class="text-sm font-medium">Available</span>
                    </div>
                    <div class="legend-item flex items-center justify-center p-3 rounded-lg bg-gray-50 hover-scale">
                        <span class="w-4 h-4 bg-emerald-500 rounded-full mr-3"></span>
                        <span class="text-sm font-medium">Your Selection</span>
                    </div>
                    <div class="legend-item flex items-center justify-center p-3 rounded-lg bg-gray-50 hover-scale">
                        <span class="w-4 h-4 bg-red-500 rounded-full mr-3"></span>
                        <span class="text-sm font-medium">Occupied</span>
                    </div>
                </div>
                <div class="flex justify-center items-center gap-8 pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-table text-emerald-600 text-lg"></i>
                        <span class="font-medium">45 Tables</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-chair text-emerald-600 text-lg"></i>
                        <span class="font-medium">10 Seats per table</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seating map -->
        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100 fade-in">
            <div id="seating-map" class="relative mx-auto bg-pattern rounded-lg p-6">
                <!-- Tables and seats will be dynamically added here by JavaScript -->
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/20 to-transparent rounded-lg"></div>
            </div>
        </div>
    </main>

    <!-- Toast notification -->
    <div id="toast" class="fixed bottom-4 right-4 transform transition-all duration-300 translate-y-full">
        <div class="bg-emerald-600 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <i class="fas fa-info-circle"></i>
            <span id="toast-message"></span>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-sm mx-4 shadow-xl transform transition-all duration-300">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-check-circle text-emerald-600"></i>
                Confirm Seat Selection
            </h3>
            <p class="text-gray-600 mb-6">Are you sure you want to select this seat? <span id="seatDetails" class="font-medium text-gray-900"></span></p>
            <div class="flex justify-end gap-3">
                <button id="cancelSeatBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    Cancel
                </button>
                <button id="confirmSeatBtn" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <!-- Deselection Confirmation Modal -->
    <div id="deselectModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-sm mx-4 shadow-xl transform transition-all duration-300">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-times-circle text-red-600"></i>
                Confirm Seat Removal
            </h3>
            <p class="text-gray-600 mb-6">Are you sure you want to remove yourself from this seat? <span id="deselectSeatDetails" class="font-medium text-gray-900"></span></p>
            <div class="flex justify-end gap-3">
                <button id="cancelDeselectBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    Cancel
                </button>
                <button id="confirmDeselectBtn" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                    Remove
                </button>
            </div>
        </div>
    </div>

    <!-- Admin Seat Assignment Modal -->
    <div id="admin-assign-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Assign Seat <span id="admin-seat-details" class="text-sm text-gray-500"></span></h3>
                <button onclick="hideAdminModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <button onclick="assignToSelf()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Assign to myself
                </button>
                
                <button onclick="showUserList()" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Assign to another user
                </button>

                <button onclick="clearSeat()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Clear Seat
                </button>
            </div>

            <!-- User selection section -->
            <div id="user-list-section" class="hidden mt-4">
                <div class="mb-4">
                    <input type="text" id="user-search" placeholder="Search users..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div id="user-list" class="space-y-2 max-h-60 overflow-y-auto">
                    <!-- User list will be populated here -->
                </div>
                <button id="confirm-admin-assign" onclick="confirmAssignment()" 
                    class="hidden w-full mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Confirm Assignment
                </button>
            </div>
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
        let pendingSeatId = null;

        // DOM Elements
        const seatingMap = document.getElementById('seating-map');
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        const confirmationModal = document.getElementById('confirmationModal');
        const deselectModal = document.getElementById('deselectModal');
        const seatDetails = document.getElementById('seatDetails');
        const deselectSeatDetails = document.getElementById('deselectSeatDetails');
        const confirmSeatBtn = document.getElementById('confirmSeatBtn');
        const cancelSeatBtn = document.getElementById('cancelSeatBtn');
        const confirmDeselectBtn = document.getElementById('confirmDeselectBtn');
        const cancelDeselectBtn = document.getElementById('cancelDeselectBtn');

        // New variables for admin functionality
        const isAdmin = <?php echo json_encode($user['is_admin']); ?>;
        const adminAssignModal = document.getElementById('admin-assign-modal');
        const adminSeatDetails = document.getElementById('admin-seat-details');
        const assignToSelfBtn = document.getElementById('assignToSelfBtn');
        const showUserListBtn = document.getElementById('showUserListBtn');
        const userListSection = document.getElementById('user-list-section');
        const userSearch = document.getElementById('user-search');
        const userList = document.getElementById('user-list');
        const cancelAdminAssignBtn = document.getElementById('cancelAdminAssignBtn');
        const confirmAdminAssignBtn = document.getElementById('confirm-admin-assign');
        let selectedUserId = null;
        let unseatedUsers = [];

        // Show/hide modal functions
        function showModal(seatId, isDeselect = false) {
            const tableNum = Math.floor((seatId - 1) / 10) + 1;
            const seatNum = ((seatId - 1) % 10) + 1;
            const details = `(Table ${tableNum}, Seat ${seatNum})`;
            
            if (isDeselect) {
                deselectSeatDetails.textContent = details;
                deselectModal.classList.remove('hidden');
                deselectModal.classList.add('flex');
                setTimeout(() => {
                    deselectModal.querySelector('.bg-white').classList.add('scale-100', 'opacity-100');
                    deselectModal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
                }, 10);
            } else {
                seatDetails.textContent = details;
                confirmationModal.classList.remove('hidden');
                confirmationModal.classList.add('flex');
                setTimeout(() => {
                    confirmationModal.querySelector('.bg-white').classList.add('scale-100', 'opacity-100');
                    confirmationModal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
                }, 10);
            }
            pendingSeatId = seatId;
        }

        function hideModals() {
            const confirmationContent = confirmationModal.querySelector('.bg-white');
            const deselectContent = deselectModal.querySelector('.bg-white');
            
            confirmationContent.classList.remove('scale-100', 'opacity-100');
            confirmationContent.classList.add('scale-95', 'opacity-0');
            deselectContent.classList.remove('scale-100', 'opacity-100');
            deselectContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                confirmationModal.classList.add('hidden');
                confirmationModal.classList.remove('flex');
                deselectModal.classList.add('hidden');
                deselectModal.classList.remove('flex');
                pendingSeatId = null;
            }, 200);
        }

        // Modal event listeners
        confirmSeatBtn.addEventListener('click', async () => {
            if (pendingSeatId !== null) {
                await updateSeat(pendingSeatId, true);
                hideModals();
            }
        });

        confirmDeselectBtn.addEventListener('click', async () => {
            if (pendingSeatId !== null) {
                await updateSeat(pendingSeatId, false);
                hideModals();
            }
        });

        cancelSeatBtn.addEventListener('click', hideModals);
        cancelDeselectBtn.addEventListener('click', hideModals);

        // Close modals when clicking outside
        confirmationModal.addEventListener('click', (e) => {
            if (e.target === confirmationModal) {
                hideModals();
            }
        });

        deselectModal.addEventListener('click', (e) => {
            if (e.target === deselectModal) {
                hideModals();
            }
        });

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

            if (isAdmin && !isSelected) {
                // Show admin assignment modal
                showAdminModal(seatId);
                return;
            }

            if (isOccupied) {
                showToast('This seat is already taken');
                return;
            }

            if (!isSelected && selectedSeats.length >= maxSeats) {
                showToast(`You can only select ${maxSeats} seat${maxSeats > 1 ? 's' : ''}`);
                return;
            }

            // Show appropriate confirmation modal
            showModal(seatId, isSelected);
        }

        // Update seat in database
        async function updateSeat(seatId, isSelecting) {
            const seat = document.querySelector(`[data-seat-id="${seatId}"]`);

            try {
                const response = await fetch('api/update_seat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `seat_id=${seatId}&occupied=${isSelecting ? 1 : 0}`,
                });

                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.message || 'Failed to update seat');
                }

                if (!isSelecting) {
                    selectedSeats = selectedSeats.filter(id => id !== seatId);
                    seat.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
                    seat.classList.add('bg-gray-200', 'hover:bg-gray-300');
                    delete occupiedSeats[seatId];
                    
                    // Show success message for seat deselection
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300';
                    successMessage.textContent = 'Seat removed successfully';
                    document.body.appendChild(successMessage);
                    
                    // Remove success message after 3 seconds with fade out animation
                    setTimeout(() => {
                        successMessage.style.transform = 'translateY(100%)';
                        setTimeout(() => successMessage.remove(), 300);
                    }, 3000);
                } else {
                    selectedSeats.push(seatId);
                    seat.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                    seat.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
                    occupiedSeats[seatId] = userId;
                    
                    // Show success message for seat selection
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300';
                    successMessage.textContent = 'Seat selected successfully';
                    document.body.appendChild(successMessage);
                    
                    // Remove success message after 3 seconds with fade out animation
                    setTimeout(() => {
                        successMessage.style.transform = 'translateY(100%)';
                        setTimeout(() => successMessage.remove(), 300);
                    }, 3000);
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
                            seatElement.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
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

        // Admin modal functions
        function showAdminModal(seatId) {
            const tableNum = Math.floor((seatId - 1) / 10) + 1;
            const seatNum = ((seatId - 1) % 10) + 1;
            adminSeatDetails.textContent = `(Table ${tableNum}, Seat ${seatNum})`;
            
            // Reset state
            selectedUserId = null;
            userListSection.classList.add('hidden');
            confirmAdminAssignBtn.classList.add('hidden');
            userSearch.value = '';
            
            // Show modal
            adminAssignModal.classList.remove('hidden');
            adminAssignModal.classList.add('flex');
            pendingSeatId = seatId;

            // Load unseated users
            loadUnseatedUsers();
        }

        function hideAdminModal() {
            adminAssignModal.classList.add('hidden');
            adminAssignModal.classList.remove('flex');
            pendingSeatId = null;
            selectedUserId = null;
        }

        // Load unseated users
        async function loadUnseatedUsers() {
            try {
                const response = await fetch('api/get_unseated_users.php');
                if (!response.ok) throw new Error('Failed to load unseated users');
                unseatedUsers = await response.json();
                updateUserList();
            } catch (error) {
                console.error('Error loading unseated users:', error);
                showToast('Failed to load user list');
            }
        }

        // Update user list based on search
        function updateUserList() {
            const searchTerm = userSearch.value.toLowerCase();
            const filteredUsers = unseatedUsers.filter(user => 
                user.name.toLowerCase().includes(searchTerm) || 
                user.email.toLowerCase().includes(searchTerm)
            );

            userList.innerHTML = filteredUsers.map(user => `
                <button class="w-full text-left px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 user-select-btn"
                        data-user-id="${user.id}">
                    <div class="flex justify-between items-center">
                        <span>${user.name}</span>
                        <span class="text-xs text-gray-500">${user.missing_seats} seat${user.missing_seats > 1 ? 's' : ''} needed</span>
                    </div>
                    <div class="text-xs text-gray-500">${user.email}</div>
                </button>
            `).join('');

            // Add click handlers
            document.querySelectorAll('.user-select-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.user-select-btn').forEach(b => 
                        b.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50'));
                    btn.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50');
                    selectedUserId = parseInt(btn.dataset.userId);
                    confirmAdminAssignBtn.classList.remove('hidden');
                });
            });
        }

        // Event listeners for admin modal
        assignToSelfBtn.addEventListener('click', () => {
            selectedUserId = userId;
            userListSection.classList.add('hidden');
            confirmAdminAssignBtn.classList.remove('hidden');
        });

        showUserListBtn.addEventListener('click', () => {
            selectedUserId = null;
            userListSection.classList.remove('hidden');
            confirmAdminAssignBtn.classList.add('hidden');
        });

        userSearch.addEventListener('input', updateUserList);

        cancelAdminAssignBtn.addEventListener('click', hideAdminModal);

        confirmAdminAssignBtn.addEventListener('click', async () => {
            if (pendingSeatId !== null && selectedUserId !== null) {
                try {
                    const response = await fetch('api/admin_assign_seat.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `seat_id=${pendingSeatId}&user_id=${selectedUserId}`,
                    });

                    if (!response.ok) {
                        const data = await response.json();
                        throw new Error(data.error || 'Failed to assign seat');
                    }

                    // Update UI
                    const seat = document.querySelector(`[data-seat-id="${pendingSeatId}"]`);
                    if (selectedUserId === userId) {
                        selectedSeats.push(pendingSeatId);
                        seat.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                        seat.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
                    } else {
                        seat.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                        seat.classList.add('bg-red-500', 'hover:bg-red-600');
                    }
                    occupiedSeats[pendingSeatId] = selectedUserId;

                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300';
                    successMessage.textContent = 'Seat assigned successfully';
                    document.body.appendChild(successMessage);
                    
                    setTimeout(() => {
                        successMessage.style.transform = 'translateY(100%)';
                        setTimeout(() => successMessage.remove(), 300);
                    }, 3000);

                    hideAdminModal();
                } catch (error) {
                    showToast(error.message);
                }
            }
        });

        adminAssignModal.addEventListener('click', (e) => {
            if (e.target === adminAssignModal) {
                hideAdminModal();
            }
        });

        async function clearSeat() {
            if (!pendingSeatId) return;
            
            try {
                const response = await fetch('api/clear_seat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `seat_id=${pendingSeatId}`
                });

                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.error || 'Failed to clear seat');
                }

                // Hide modal and refresh seats
                hideAdminModal();
                await loadSeatStatus();
                showToast('Seat cleared successfully');
            } catch (error) {
                console.error('Error clearing seat:', error);
                showToast(error.message || 'Failed to clear seat');
            }
        }
    </script>
</body>
</html> 