<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitr for Luxury Galas - Elegant Event Seating</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #7C3AED, #C4B5FD);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .feature-icon {
            background: linear-gradient(135deg, #7C3AED, #C4B5FD);
        }
        .hero-glow-1 {
            background: #7C3AED;
            top: -100px;
            right: -100px;
        }
        .hero-glow-2 {
            background: #C4B5FD;
            bottom: -100px;
            left: -100px;
        }
        .gold-accent {
            color: #B7791F;
        }
    </style>
</head>
<body class="bg-purple-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-purple-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="#" class="text-2xl font-bold text-purple-600">Sitr</a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-purple-600 transition-colors">Features</a>
                    <a href="#benefits" class="text-gray-700 hover:text-purple-600 transition-colors">Benefits</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-purple-600 transition-colors">How It Works</a>
                    <a href="#pricing" class="text-gray-700 hover:text-purple-600 transition-colors">Pricing</a>
                    <a href="login.php" class="text-purple-600 hover:text-purple-700 transition-colors font-medium">Log in</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with PAS Framework -->
    <header class="relative min-h-screen flex items-center bg-gradient-to-br from-purple-50 via-white to-yellow-50/20 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(circle_at_1px_1px,#7C3AED_1px,transparent_0)]" style="background-size: 40px 40px;"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 grid lg:grid-cols-2 gap-12 items-center">
            <div class="max-w-xl">
                <!-- Problem -->
                <div class="mb-8">
                    <span class="inline-block px-4 py-2 rounded-full bg-purple-100 text-purple-600 font-semibold text-sm mb-4">Donor Engagement Challenges?</span>
                    <h2 class="text-2xl text-gray-900 mb-4">
                        Are your galas missing meaningful connections?
                    </h2>
                    
                    <!-- Agitate -->
                    <div class="space-y-4 mb-6">
                        <p class="text-gray-600">
                            <i class="fas fa-times text-purple-500 mr-2"></i>
                            VIP donors seated away from key stakeholders
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-times text-purple-500 mr-2"></i>
                            Missed fundraising opportunities due to poor table arrangements
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-times text-purple-500 mr-2"></i>
                            Last-minute seating changes creating diplomatic tensions
                        </p>
                    </div>

                    <!-- Solution -->
                    <h1 class="text-5xl sm:text-6xl font-bold tracking-tight mb-6">
                        <span class="block text-gray-900">Orchestrate</span>
                        <span class="block gradient-text">Perfect Connections</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-6">
                        Elevate your prestigious events with strategic seating that maximizes donor engagement, facilitates meaningful networking, and enhances fundraising outcomes.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="register.php" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                            Request Private Demo
                        </a>
                        <a href="#how-it-works" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Discover More
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-600 mr-2"></i>
                        White Glove Support
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-lock text-yellow-600 mr-2"></i>
                        Premium Security
                    </div>
                </div>
            </div>
            <div class="relative">
                <img src="assets/images/luxury-gala.jpg" alt="Luxury Gala Setup" 
                    class="rounded-3xl shadow-2xl w-full h-[600px] object-cover transform hover:scale-[1.02] transition-transform duration-500">
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-purple-200/50 rounded-full filter blur-2xl"></div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="inline-block px-4 py-2 rounded-full bg-purple-100 text-purple-600 font-semibold text-sm mb-4">Premium Features</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Crafted for Prestigious Events
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 lg:mx-auto">
                    Sophisticated features designed for high-end galas and charity events.
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="relative p-6 bg-purple-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-user-tie text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">VIP Management</h3>
                            <p class="mt-2 text-gray-600">
                                Prioritize key donors and VIP guests with specialized seating arrangements.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative p-6 bg-purple-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-handshake text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Strategic Networking</h3>
                            <p class="mt-2 text-gray-600">
                                Optimize seating for meaningful connections and donor engagement.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative p-6 bg-purple-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-concierge-bell text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Concierge Service</h3>
                            <p class="mt-2 text-gray-600">
                                Dedicated support team for white-glove service and customization.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-purple-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Elevate Your Next Prestigious Event</h2>
            <p class="text-xl mb-8">Join leading organizations using Sitr for their high-profile galas.</p>
            <a href="register.php" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-purple-600 bg-white hover:bg-purple-50 transition-colors">
                Request Private Demo
            </a>
        </div>
    </section>
</body>
</html> 