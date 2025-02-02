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
                    Total Seats: 45
                </div>
            </div>

            <div id="seating-map" class="relative mx-auto bg-gray-50 rounded-lg p-8">
                <!-- Seats will be dynamically added here by JavaScript -->
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
            totalSeats: 45,
            seatsPerRow: 9,
            seatSize: 40,
            seatSpacing: 10,
            rowSpacing: 20
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
        function createSeat(seatId) {
            const row = Math.floor((seatId - 1) / config.seatsPerRow);
            const col = (seatId - 1) % config.seatsPerRow;
            
            const x = col * (config.seatSize + config.seatSpacing);
            const y = row * (config.seatSize + config.rowSpacing);

            const seat = document.createElement('button');
            seat.className = 'absolute rounded-lg bg-gray-200 hover:bg-gray-300 focus:outline-none seat-btn transition-colors duration-200';
            seat.style.cssText = `
                width: ${config.seatSize}px;
                height: ${config.seatSize}px;
                left: ${x}px;
                top: ${y}px;
            `;
            seat.dataset.seatId = seatId;
            seat.setAttribute('aria-label', `Seat ${seatId}`);

            if (showOccupiedNames) {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip opacity-0 invisible absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-sm text-white bg-gray-900 rounded whitespace-nowrap transition-all duration-200';
                seat.appendChild(tooltip);

                seat.addEventListener('mouseenter', async () => {
                    if (occupiedSeats[seatId] && occupiedSeats[seatId] !== userId) {
                        try {
                            const response = await fetch(`api/get_user.php?id=${occupiedSeats[seatId]}`);
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

            // Add seat number
            const seatNumber = document.createElement('span');
            seatNumber.className = 'absolute inset-0 flex items-center justify-center text-sm font-medium text-gray-700';
            seatNumber.textContent = seatId;
            seat.appendChild(seatNumber);

            seat.addEventListener('click', () => handleSeatClick(seatId));
            return seat;
        }

        // Create seating layout
        function createSeatingLayout() {
            seatingMap.innerHTML = '';
            
            // Calculate container size
            const containerWidth = (config.seatsPerRow * config.seatSize) + ((config.seatsPerRow - 1) * config.seatSpacing);
            const containerHeight = (Math.ceil(config.totalSeats / config.seatsPerRow) * config.seatSize) + 
                                 ((Math.ceil(config.totalSeats / config.seatsPerRow) - 1) * config.rowSpacing);
            
            seatingMap.style.width = `${containerWidth + 40}px`;
            seatingMap.style.height = `${containerHeight + 40}px`;
            seatingMap.style.margin = '0 auto';

            // Create seats
            for (let i = 1; i <= config.totalSeats; i++) {
                const seat = createSeat(i);
                seatingMap.appendChild(seat);
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

                seats.forEach(seat => {
                    occupiedSeats[seat.seat_id] = seat.user_id;
                    const seatElement = document.querySelector(`[data-seat-id="${seat.seat_id}"]`);
                    
                    if (seatElement) {
                        if (seat.user_id === userId) {
                            selectedSeats.push(seat.seat_id);
                            seatElement.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                            seatElement.classList.add('bg-blue-500', 'hover:bg-blue-600');
                        } else {
                            seatElement.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                            seatElement.classList.add('bg-red-500', 'hover:bg-red-600');
                        }
                    }
                });
            } catch (error) {
                showToast('Failed to load seat status');
            }
        }

        // Initialize
        createSeatingLayout();
        loadSeatStatus();
    </script>
</body>
</html> 