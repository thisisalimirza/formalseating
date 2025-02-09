<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitr for Startup Events - Smart Networking Seating</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #10B981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .feature-icon {
            background: linear-gradient(135deg, #10B981, #059669);
        }
        .hero-glow-1 {
            background: #10B981;
            top: -100px;
            right: -100px;
        }
        .hero-glow-2 {
            background: #059669;
            bottom: -100px;
            left: -100px;
        }
    </style>
</head>
<body class="bg-emerald-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-emerald-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="#" class="text-2xl font-bold text-emerald-600">Sitr</a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-emerald-600 transition-colors">Features</a>
                    <a href="#benefits" class="text-gray-700 hover:text-emerald-600 transition-colors">Benefits</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-emerald-600 transition-colors">How It Works</a>
                    <a href="#pricing" class="text-gray-700 hover:text-emerald-600 transition-colors">Pricing</a>
                    <a href="login.php" class="text-emerald-600 hover:text-emerald-700 transition-colors font-medium">Log in</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with PAS Framework -->
    <header class="relative min-h-screen flex items-center bg-gradient-to-br from-emerald-50 via-white to-teal-50/20 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(circle_at_1px_1px,#10B981_1px,transparent_0)]" style="background-size: 40px 40px;"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 grid lg:grid-cols-2 gap-12 items-center">
            <div class="max-w-xl">
                <!-- Problem -->
                <div class="mb-8">
                    <span class="inline-block px-4 py-2 rounded-full bg-emerald-100 text-emerald-600 font-semibold text-sm mb-4">Missing Key Connections?</span>
                    <h2 class="text-2xl text-gray-900 mb-4">
                        Are your founder dinners failing to deliver real value?
                    </h2>
                    
                    <!-- Agitate -->
                    <div class="space-y-4 mb-6">
                        <p class="text-gray-600">
                            <i class="fas fa-times text-emerald-500 mr-2"></i>
                            Founders not meeting the right investors for their stage
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-times text-emerald-500 mr-2"></i>
                            Missed partnership opportunities due to random seating
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-times text-emerald-500 mr-2"></i>
                            Low ROI from networking events without strategic matching
                        </p>
                    </div>

                    <!-- Solution -->
                    <h1 class="text-5xl sm:text-6xl font-bold tracking-tight mb-6">
                        <span class="block text-gray-900">Engineer</span>
                        <span class="block gradient-text">Perfect Matches</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-6">
                        Transform your startup dinners into high-impact networking events with AI-powered seating that connects the right founders with the right investors and partners.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="register.php" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 transition-colors">
                            Start Free
                        </a>
                        <a href="#how-it-works" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            See How It Works
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-bolt text-emerald-600 mr-2"></i>
                        5-Minute Setup
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-emerald-600 mr-2"></i>
                        Maximize ROI
                    </div>
                </div>
            </div>
            <div class="relative">
                <img src="assets/images/startup-dinner.jpg" alt="Startup Networking Dinner" 
                    class="rounded-3xl shadow-2xl w-full h-[600px] object-cover transform hover:scale-[1.02] transition-transform duration-500">
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-emerald-200/50 rounded-full filter blur-2xl"></div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="inline-block px-4 py-2 rounded-full bg-emerald-100 text-emerald-600 font-semibold text-sm mb-4">Smart Features</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Built for Startup Networking
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 lg:mx-auto">
                    Features designed to maximize meaningful connections at your startup events.
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="relative p-6 bg-emerald-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-network-wired text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Smart Matching</h3>
                            <p class="mt-2 text-gray-600">
                                AI-powered seating arrangements based on industry, interests, and investment stage.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative p-6 bg-emerald-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-lightbulb text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Interest Matching</h3>
                            <p class="mt-2 text-gray-600">
                                Connect founders with relevant investors and potential partners.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative p-6 bg-emerald-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-chart-pie text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Analytics</h3>
                            <p class="mt-2 text-gray-600">
                                Track networking success and optimize future event seating.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof Section -->
    <section class="py-20 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <div class="text-4xl font-bold text-emerald-600 mb-2">500+</div>
                    <div class="text-gray-600">Startup Events</div>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <div class="text-4xl font-bold text-emerald-600 mb-2">$100M+</div>
                    <div class="text-gray-600">Funding Secured</div>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <div class="text-4xl font-bold text-emerald-600 mb-2">95%</div>
                    <div class="text-gray-600">Success Rate</div>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Founder" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <div class="font-semibold">Alex Chen</div>
                            <div class="text-sm text-gray-600">Founder, TechStart</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Met our lead investor at a Sitr-powered dinner. The smart seating algorithm paired us perfectly based on industry and stage. Closed $2M seed round within weeks."</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="VC" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <div class="font-semibold">Sarah Williams</div>
                            <div class="text-sm text-gray-600">Partner, Innovation VC</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"As an investor, time is precious. Sitr ensures I'm seated with founders in my target sectors and stage. Every dinner has led to at least one promising investment."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">How It Works</h2>
                <p class="mt-4 text-xl text-gray-600">Four simple steps to networking success</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-upload text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">1. Upload Profiles</h3>
                    <p class="text-gray-600">Add attendee details including industry, interests, and investment criteria</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-magic text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">2. AI Matching</h3>
                    <p class="text-gray-600">Our algorithm creates optimal seating arrangements</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-share-alt text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">3. Share Plans</h3>
                    <p class="text-gray-600">Send personalized seating assignments to attendees</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">4. Track Success</h3>
                    <p class="text-gray-600">Measure networking outcomes and optimize future events</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Deep Dive -->
    <section class="py-20 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Why Founders & Investors Love Sitr</h2>
                <p class="mt-4 text-xl text-gray-600">Maximize the value of every networking dinner</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <h3 class="text-xl font-semibold mb-4">For Founders</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check text-emerald-600 mt-1 mr-3"></i>
                            <span>Connect with investors matching your industry and stage</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-emerald-600 mt-1 mr-3"></i>
                            <span>Find potential co-founders and strategic partners</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-emerald-600 mt-1 mr-3"></i>
                            <span>Access post-event analytics and follow-up tools</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <h3 class="text-xl font-semibold mb-4">For Investors</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check text-emerald-600 mt-1 mr-3"></i>
                            <span>Meet founders in your target sectors and investment stages</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-emerald-600 mt-1 mr-3"></i>
                            <span>Discover trending startups before they hit the market</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-emerald-600 mt-1 mr-3"></i>
                            <span>Build relationships with other investors for deal flow</span>
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
                <h2 class="text-3xl font-bold text-gray-900">Frequently Asked Questions</h2>
                <p class="mt-4 text-xl text-gray-600">Everything you need to know about Sitr</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold mb-2">How does the matching algorithm work?</h3>
                    <p class="text-gray-600">Our AI considers multiple factors including industry focus, investment stage, previous connections, and mutual interests to create optimal seating arrangements.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Can I customize matching criteria?</h3>
                    <p class="text-gray-600">Yes! Event organizers can adjust matching weights and add custom criteria to ensure the most relevant connections for their specific event.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">What's the pricing model?</h3>
                    <p class="text-gray-600">We offer flexible per-event pricing with unlimited attendees. Contact us for custom enterprise plans for regular events.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">How do you measure success?</h3>
                    <p class="text-gray-600">We track various metrics including successful matches, follow-up meetings, and investment outcomes to continuously improve our algorithm.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-emerald-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Supercharge Your Startup Events?</h2>
            <p class="text-xl mb-8">Join successful founders and investors using Sitr for their networking events.</p>
            <a href="register.php" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-emerald-600 bg-white hover:bg-emerald-50 transition-colors">
                Get Started Free
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Sitr</h3>
                    <p class="text-gray-400">Transforming startup networking through intelligent seating arrangements.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Product</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#about">About</a></li>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#careers">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#twitter">Twitter</a></li>
                        <li><a href="#linkedin">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Sitr. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> 