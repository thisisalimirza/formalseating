<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitr - Modern Event Seating Management</title>
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
        .hero-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
            filter: brightness(0.8);
        }
        @media (max-width: 1024px) {
            .hero-image {
                height: 400px;
            }
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="#" class="text-2xl font-bold text-blue-600">Sitr</a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-gray-900">Features</a>
                    <a href="#benefits" class="text-gray-600 hover:text-gray-900">Benefits</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-gray-900">How It Works</a>
                    <a href="#pricing" class="text-gray-600 hover:text-gray-900">Pricing</a>
                    <a href="login.php" class="text-blue-600 hover:text-blue-700">Log in</a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-600 hover:text-gray-900">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative min-h-screen flex items-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80" 
                 alt="Elegant event venue" 
                 class="hero-image">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="max-w-xl">
                <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-gray-900 mb-6">
                    <span class="block">Seamless Event</span>
                    <span class="block text-blue-600">Seating Made Simple</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Sitr transforms event seating management with an intuitive platform that makes selecting and managing seats effortless for any formal event or gathering.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="register.php" class="inline-flex justify-center items-center px-8 py-3 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition-colors">
                        Get Started
                    </a>
                    <a href="#how-it-works" class="inline-flex justify-center items-center px-8 py-3 rounded-lg bg-blue-50 text-blue-600 font-medium hover:bg-blue-100 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Everything You Need for Perfect Event Seating
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Our comprehensive platform offers all the tools you need to manage event seating arrangements with ease.
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
                            <h3 class="text-lg font-medium text-gray-900">Guest Management</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Easily manage companion seating and group arrangements.
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
                                Instant notifications and confirmations for all seating actions.
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
                                Select and manage seats anytime, anywhere.
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
                    Why Choose Sitr?
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

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Simple, Transparent Pricing
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Choose the perfect plan for your event size and needs
                </p>
            </div>

            <!-- Attendee Calculator -->
            <div class="mt-12 max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Make Sitr Free for Your Event</h3>
                <div class="space-y-6">
                    <div class="text-sm text-gray-600">
                        <p class="mb-2"><span class="font-semibold text-blue-600">Pro Tip:</span> Add the small per-ticket amount shown below to your ticket price, and Sitr pays for itself while giving your attendees a fantastic seating experience!</p>
                    </div>
                    <div>
                        <label for="attendees" class="block text-sm font-medium text-gray-700">
                            Expected Number of Attendees: <span id="attendeeCount" class="text-blue-600 font-semibold">200</span>
                        </label>
                        <input type="range" id="attendees" name="attendees" min="50" max="500" value="200" step="10"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer mt-2">
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-medium text-blue-900 mb-2">How It Works:</h4>
                        <p class="text-sm text-blue-800">
                            For example, with <span id="exampleAttendees">200</span> attendees on our Pro plan:
                        </p>
                        <ul class="mt-2 space-y-2 text-sm text-blue-800">
                            <li class="flex items-center">
                                <i class="fas fa-plus text-green-500 mr-2"></i>
                                Add just <span id="exampleCost" class="font-bold">$1.00</span> to each ticket price
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Your attendees get a seamless seating experience
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                You save hours of manual seating coordination
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Sitr completely pays for itself!
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Basic Plan -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-gray-400">
                        <div class="px-6 py-8">
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-gray-900">Basic</h3>
                                <p class="mt-2 text-gray-500">Perfect for small events</p>
                                <div class="mt-4">
                                    <span class="text-4xl font-bold text-gray-900">$99</span>
                                    <span class="text-gray-500">/event</span>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Add just <span id="basicPerTicket" class="font-semibold">$1.65</span> per ticket
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <ul class="space-y-4">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Up to 100 guests</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Interactive seating map</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Real-time updates</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Email support</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-8">
                                <a href="register.php" class="block w-full text-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    Get Started
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pro Plan -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-blue-500 transform scale-105">
                        <div class="px-6 py-8">
                            <div class="absolute top-0 right-0 mt-4 mr-4">
                                <span class="bg-blue-500 text-white text-sm px-3 py-1 rounded-full">Popular</span>
                            </div>
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-gray-900">Pro</h3>
                                <p class="mt-2 text-gray-500">For medium-sized events</p>
                                <div class="mt-4">
                                    <span class="text-4xl font-bold text-gray-900">$199</span>
                                    <span class="text-gray-500">/event</span>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Add just <span id="proPerTicket" class="font-semibold">$2.65</span> per ticket
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <ul class="space-y-4">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Up to 300 guests</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>All Basic features</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Guest management tools</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Priority support</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Custom branding</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-8">
                                <a href="register.php" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Get Started
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-gray-800">
                        <div class="px-6 py-8">
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-gray-900">Enterprise</h3>
                                <p class="mt-2 text-gray-500">For large events</p>
                                <div class="mt-4">
                                    <span class="text-4xl font-bold text-gray-900">Custom</span>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Add just <span id="enterprisePerTicket" class="font-semibold">$3.65</span> per ticket
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <ul class="space-y-4">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Unlimited guests</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>All Pro features</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Dedicated support</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Custom integrations</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Advanced analytics</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-8">
                                <a href="register.php" class="block w-full text-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    Contact Sales
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-blue-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to simplify your event seating?</span>
                <span class="block text-blue-200">Get started with Sitr today.</span>
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
                        &copy; 2024 Sitr. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Add this before the closing </body> tag -->
    <script>
        // Pricing calculator
        const attendeeSlider = document.getElementById('attendees');
        const attendeeCount = document.getElementById('attendeeCount');
        const basicPerTicket = document.getElementById('basicPerTicket');
        const proPerTicket = document.getElementById('proPerTicket');
        const enterprisePerTicket = document.getElementById('enterprisePerTicket');
        const exampleAttendees = document.getElementById('exampleAttendees');
        const exampleCost = document.getElementById('exampleCost');

        function updatePricing() {
            const attendees = parseInt(attendeeSlider.value);
            attendeeCount.textContent = attendees;
            exampleAttendees.textContent = attendees;

            // Calculate per-ticket costs
            const basicCost = (99 / attendees).toFixed(2);
            const proCost = (199 / attendees).toFixed(2);
            const enterpriseCost = ((299 + (attendees * 0.25)) / attendees).toFixed(2);

            // Determine which plan to show in the example based on attendee count
            let examplePlanName = '';
            let examplePlanCost = '';

            if (attendees <= 100) {
                examplePlanName = 'Basic';
                examplePlanCost = basicCost;
            } else if (attendees <= 300) {
                examplePlanName = 'Pro';
                examplePlanCost = proCost;
            } else {
                examplePlanName = 'Enterprise';
                examplePlanCost = enterpriseCost;
            }

            // Update display for Basic plan
            if (attendees > 100) {
                basicPerTicket.parentElement.innerHTML = `<span class="text-red-500">Exceeds plan limit<br/>(max 100 attendees)</span>`;
            } else {
                basicPerTicket.parentElement.innerHTML = `Add just <span id="basicPerTicket" class="font-semibold">$${basicCost}</span> per ticket`;
                // Re-assign element since we recreated it
                basicPerTicket = document.getElementById('basicPerTicket');
            }

            // Update display for Pro plan
            if (attendees > 300) {
                proPerTicket.parentElement.innerHTML = `<span class="text-red-500">Exceeds plan limit<br/>(max 300 attendees)</span>`;
            } else {
                proPerTicket.parentElement.innerHTML = `Add just <span id="proPerTicket" class="font-semibold">$${proCost}</span> per ticket`;
                // Re-assign element since we recreated it
                proPerTicket = document.getElementById('proPerTicket');
            }

            // Always update Enterprise plan since it has no limit
            enterprisePerTicket.textContent = `$${enterpriseCost}`;

            // Update the example text and cost
            document.querySelector('.text-blue-800').innerHTML = `
                For example, with <span id="exampleAttendees">${attendees}</span> attendees on our ${examplePlanName} plan:
            `;
            exampleCost.textContent = `$${examplePlanCost}`;
        }

        attendeeSlider.addEventListener('input', updatePricing);
        updatePricing(); // Initial calculation
    </script>
</body>
</html> 