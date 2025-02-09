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

    <!-- Social Proof Section -->
    <section class="py-20 bg-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Trusted by Happy Couples Everywhere</h2>
                <div class="mt-8 flex justify-center gap-8">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-rose-500">2,500+</div>
                        <div class="mt-2 text-gray-600">Weddings</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-rose-500">250,000+</div>
                        <div class="mt-2 text-gray-600">Guests Seated</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-rose-500">98%</div>
                        <div class="mt-2 text-gray-600">Satisfaction Rate</div>
                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="grid md:grid-cols-3 gap-8 mt-16">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah" class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h3 class="font-semibold">Sarah & Michael</h3>
                            <div class="text-rose-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Sitr saved us countless hours of stress! Our guests loved choosing their seats, and it prevented so many potential family dramas. Best wedding planning decision we made!"</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="James" class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h3 class="font-semibold">James & David</h3>
                            <div class="text-rose-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"The self-service seating was a game-changer. No more Excel sheets or sticky notes! Our guests actually enjoyed the seating process, and everyone was happy with their spots."</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emma" class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h3 class="font-semibold">Emma & Chris</h3>
                            <div class="text-rose-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Worth every penny! We had a complex situation with divorced parents and step-families. Sitr made it easy for everyone to choose comfortable seating arrangements."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full bg-rose-100 text-rose-500 font-semibold text-sm mb-4">Simple Process</span>
                <h2 class="text-3xl font-bold text-gray-900">How Sitr Makes Seating Effortless</h2>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-upload text-2xl text-rose-500"></i>
                    </div>
                    <h3 class="font-semibold mb-2">1. Upload Guest List</h3>
                    <p class="text-gray-600">Import your guest list from Excel or your wedding planning tool</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-table text-2xl text-rose-500"></i>
                    </div>
                    <h3 class="font-semibold mb-2">2. Set Up Tables</h3>
                    <p class="text-gray-600">Design your floor plan and mark any reserved tables</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-2xl text-rose-500"></i>
                    </div>
                    <h3 class="font-semibold mb-2">3. Invite Guests</h3>
                    <p class="text-gray-600">Guests receive personalized links to choose their seats</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-2xl text-rose-500"></i>
                    </div>
                    <h3 class="font-semibold mb-2">4. Done!</h3>
                    <p class="text-gray-600">Watch as seating arrangements complete themselves</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Deep Dive -->
    <section class="py-20 bg-gradient-to-b from-rose-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full bg-rose-100 text-rose-500 font-semibold text-sm mb-4">Why Couples Love Us</span>
                <h2 class="text-3xl font-bold text-gray-900">Benefits That Make a Real Difference</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <h3 class="text-xl font-semibold mb-4 flex items-center">
                        <i class="fas fa-clock text-rose-500 mr-3"></i>
                        Save 15+ Hours of Planning Time
                    </h3>
                    <p class="text-gray-600 mb-4">No more juggling spreadsheets or playing phone tag with guests. Our automated system handles everything, giving you back precious time for other wedding details.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check text-rose-500 mr-2"></i>
                            <span>Automated guest communications</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-rose-500 mr-2"></i>
                            <span>Real-time seating updates</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-rose-500 mr-2"></i>
                            <span>Instant floor plan generation</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <h3 class="text-xl font-semibold mb-4 flex items-center">
                        <i class="fas fa-heart text-rose-500 mr-3"></i>
                        Reduce Family Drama
                    </h3>
                    <p class="text-gray-600 mb-4">Let guests choose their own seats while you maintain control over table assignments. Perfect for managing complex family dynamics and ensuring everyone's comfort.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check text-rose-500 mr-2"></i>
                            <span>Handle divorced parents gracefully</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-rose-500 mr-2"></i>
                            <span>Manage plus-one seating easily</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-rose-500 mr-2"></i>
                            <span>Reserve VIP tables discreetly</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full bg-rose-100 text-rose-500 font-semibold text-sm mb-4">Common Questions</span>
                <h2 class="text-3xl font-bold text-gray-900">Frequently Asked Questions</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold mb-2">What if some guests don't use technology?</h3>
                    <p class="text-gray-600">No problem! You can easily manage seating on behalf of any guests who prefer not to use the system themselves.</p>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Can we still have a head table?</h3>
                    <p class="text-gray-600">Absolutely! You can reserve any tables and pre-assign seats for your wedding party or VIP guests.</p>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">What if we need to make last-minute changes?</h3>
                    <p class="text-gray-600">Changes can be made instantly at any time, and the system automatically updates all affected guests.</p>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">How far in advance should we start?</h3>
                    <p class="text-gray-600">Most couples start 2-3 months before the wedding, but you can begin as early as you like!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 bg-gradient-to-b from-white to-rose-50">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Ready for Stress-Free Wedding Seating?</h2>
            <p class="text-xl text-gray-600 mb-8">Join thousands of happy couples who made seating arrangements the easiest part of their wedding planning.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="register.php" class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-rose-500 hover:bg-rose-600 transition-colors">
                    Start Free Trial
                </a>
                <a href="#how-it-works" class="inline-flex justify-center items-center px-8 py-4 border border-gray-300 text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    See Demo
                </a>
            </div>
            <p class="mt-6 text-sm text-gray-600">No credit card required • 14-day free trial • Cancel anytime</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Sitr</h3>
                    <p class="text-gray-400">Making wedding seating arrangements stress-free.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Product</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#help">Help Center</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Sitr. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> 