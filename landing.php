<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCHC Formal 2025 - Seamless Seat Selection System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Hero Section -->
    <header class="relative overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                    <nav class="relative flex items-center justify-between sm:h-10">
                        <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                            <div class="flex items-center justify-between w-full md:w-auto">
                                <span class="text-2xl font-bold gradient-text">UCHC Formal 2025</span>
                            </div>
                        </div>
                        <div class="hidden md:block md:ml-10 md:pr-4 md:space-x-8">
                            <a href="#features" class="font-medium text-gray-500 hover:text-gray-900">Features</a>
                            <a href="#benefits" class="font-medium text-gray-500 hover:text-gray-900">Benefits</a>
                            <a href="#how-it-works" class="font-medium text-gray-500 hover:text-gray-900">How It Works</a>
                            <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500">Log in</a>
                        </div>
                    </nav>
                </div>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Select Your Perfect</span>
                            <span class="block gradient-text">Formal Seat</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Experience the future of event seating. Our intuitive platform makes selecting and managing your formal seats effortless, ensuring you get the best spot for an unforgettable evening.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="register.php" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                    Get Started
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#how-it-works" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg md:px-10">
                                    Learn More
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1505236858219-8359eb29e329?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2062&q=80" alt="Elegant event venue">
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Everything You Need for Perfect Seating
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Our comprehensive platform offers all the tools you need to manage your formal seating arrangements with ease.
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-map-marker-alt text-lg"></i>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">Interactive Seating Map</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Visual, intuitive interface showing real-time seat availability and table layouts.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-users text-lg"></i>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">Plus One Management</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Easily manage companion seating with our plus-one system.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-bell text-lg"></i>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">Real-Time Updates</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Instant notifications and confirmations for all your seating actions.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-lock text-lg"></i>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">Secure System</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Protected access with email verification and secure authentication.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 5 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-mobile-alt text-lg"></i>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">Mobile Friendly</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Fully responsive design works perfectly on all devices.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 6 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-clock text-lg"></i>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">24/7 Availability</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Select and manage your seats anytime, anywhere.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Why Choose Our Platform?
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Experience the advantages of our modern seating management system.
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Benefit 1 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                        <i class="fas fa-smile text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">Stress-Free Selection</h3>
                                </div>
                            </div>
                            <p class="mt-4 text-base text-gray-500">
                                No more confusion or double-bookings. Our system ensures a smooth and organized seating selection process.
                            </p>
                        </div>
                    </div>

                    <!-- Benefit 2 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                        <i class="fas fa-bolt text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">Instant Confirmation</h3>
                                </div>
                            </div>
                            <p class="mt-4 text-base text-gray-500">
                                Get immediate confirmation of your seat selection with real-time updates and notifications.
                            </p>
                        </div>
                    </div>

                    <!-- Benefit 3 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                        <i class="fas fa-sync text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">Flexible Changes</h3>
                                </div>
                            </div>
                            <p class="mt-4 text-base text-gray-500">
                                Need to make changes? Easily modify your seat selection at any time before the event.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    How It Works
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Get started in three simple steps
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-blue-100 text-blue-600 text-2xl font-bold mx-auto">
                            1
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900">Register Your Account</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Create your account using your approved email address and set your preferences.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-blue-100 text-blue-600 text-2xl font-bold mx-auto">
                            2
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900">Browse Available Seats</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Explore our interactive seating map and find your preferred location.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-blue-100 text-blue-600 text-2xl font-bold mx-auto">
                            3
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900">Confirm Your Selection</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Select your seats and receive instant confirmation of your choices.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-blue-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to secure your seat?</span>
                <span class="block text-blue-200">Register now for the UCHC Formal 2025.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="register.php" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                        Get Started
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="login.php" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 hover:bg-blue-400">
                        Sign In
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="mt-8 border-t border-gray-700 pt-8 md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <p class="text-base text-gray-400">
                        &copy; 2024 UCHC Formal. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html> 