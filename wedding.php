<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitr for Weddings - Elegant Wedding Seating Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #FF8AAE, #FF6B6B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .feature-icon {
            background: linear-gradient(135deg, #FF8AAE, #FF6B6B);
        }
        .hero-glow-1 {
            background: #FF8AAE;
            top: -100px;
            right: -100px;
        }
        .hero-glow-2 {
            background: #FF6B6B;
            bottom: -100px;
            left: -100px;
        }
    </style>
</head>
<body class="bg-rose-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-rose-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="#" class="text-2xl font-bold text-rose-500">Sitr</a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-rose-500 transition-colors">Features</a>
                    <a href="#benefits" class="text-gray-700 hover:text-rose-500 transition-colors">Benefits</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-rose-500 transition-colors">How It Works</a>
                    <a href="#pricing" class="text-gray-700 hover:text-rose-500 transition-colors">Pricing</a>
                    <a href="login.php" class="text-rose-500 hover:text-rose-600 transition-colors font-medium">Log in</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with PAS Framework -->
    <header class="relative min-h-screen flex items-center bg-gradient-to-br from-rose-50 via-white to-pink-50/20 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(circle_at_1px_1px,#FF8AAE_1px,transparent_0)]" style="background-size: 40px 40px;"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 grid lg:grid-cols-2 gap-12 items-center">
            <div class="max-w-xl">
                <!-- Problem -->
                <div class="mb-8">
                    <span class="inline-block px-4 py-2 rounded-full bg-red-100 text-red-600 font-semibold text-sm mb-4">Wedding Planning Stress?</span>
                    <h2 class="text-2xl text-gray-900 mb-4">
                        Struggling with wedding seating arrangements?
                    </h2>
                    
                    <!-- Agitate -->
                    <div class="space-y-4 mb-6">
                        <p class="text-gray-600">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Hours spent juggling guest preferences and relationships
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Last-minute changes causing chaos and stress
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-times text-red-500 mr-2"></i>
                            Family politics making decisions impossible
                        </p>
                    </div>

                    <!-- Solution -->
                    <h1 class="text-5xl sm:text-6xl font-bold tracking-tight mb-6">
                        <span class="block text-gray-900">Make Your</span>
                        <span class="block gradient-text">Reception Perfect</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-6">
                        Let your guests choose their seats in advance, while you maintain full control. No more stress, no more drama - just perfect seating arrangements.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="register.php" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-rose-500 hover:bg-rose-600 transition-colors">
                            Start Free Trial
                        </a>
                        <a href="#how-it-works" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            See How It Works
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-check text-rose-500 mr-2"></i>
                        No Credit Card Required
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check text-rose-500 mr-2"></i>
                        14-Day Free Trial
                    </div>
                </div>
            </div>
            <div class="relative">
                <img src="assets/images/wedding-seating.jpg" alt="Wedding Reception Seating" 
                    class="rounded-3xl shadow-2xl w-full h-[600px] object-cover transform hover:scale-[1.02] transition-transform duration-500">
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-rose-200/50 rounded-full filter blur-2xl"></div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="inline-block px-4 py-2 rounded-full bg-rose-100 text-rose-500 font-semibold text-sm mb-4">Wedding-Perfect Features</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Everything You Need for Perfect Reception Seating
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 lg:mx-auto">
                    Designed specifically for wedding receptions, with all the features you need to make seating arrangements stress-free.
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="relative p-6 bg-rose-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Guest Self-Selection</h3>
                            <p class="mt-2 text-gray-600">
                                Let guests choose their own seats while you maintain control over table assignments.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative p-6 bg-rose-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-heart text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Plus One Management</h3>
                            <p class="mt-2 text-gray-600">
                                Easily handle plus ones and couple seating arrangements.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative p-6 bg-rose-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-mobile-alt text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Mobile-Friendly</h3>
                            <p class="mt-2 text-gray-600">
                                Guests can select seats from any device, anytime before the big day.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-rose-500 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Make Your Wedding Reception Perfect?</h2>
            <p class="text-xl mb-8">Join thousands of happy couples who've used Sitr for their special day.</p>
            <a href="register.php" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-rose-500 bg-white hover:bg-rose-50 transition-colors">
                Start Free Trial
            </a>
        </div>
    </section>
</body>
</html> 