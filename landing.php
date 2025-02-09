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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: '#014751',
                        firefly: '#0F2830',
                        zircon: '#F8FBFF',
                        'brand-green': '#00D37F',
                        mint: '#AFF8CB',
                        banana: '#FFEEB4',
                        lilac: '#D2C4FB',
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #00D37F, #014751);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-image {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        .hero-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 211, 127, 0.1), rgba(1, 71, 81, 0.2));
            pointer-events: none;
        }
        .hero-image img {
            transform: scale(1);
            transition: transform 0.6s ease-in-out;
        }
        .hero-image:hover img {
            transform: scale(1.05);
        }
        .hero-glow {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            pointer-events: none;
        }
        .hero-glow-1 {
            background: #00D37F;
            top: -100px;
            right: -100px;
        }
        .hero-glow-2 {
            background: #014751;
            bottom: -100px;
            left: -100px;
        }
        @media (max-width: 1024px) {
            .hero-image {
                height: 400px;
                margin-top: 2rem;
            }
        }
        .feature-icon {
            background: linear-gradient(135deg, #00D37F, #AFF8CB);
        }
        .benefit-card {
            transition: transform 0.2s;
        }
        .benefit-card:hover {
            transform: translateY(-5px);
        }
        .pricing-card {
            transition: all 0.2s;
        }
        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-zircon">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-emerald/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="#" class="text-2xl font-bold text-emerald">Sitr</a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-firefly hover:text-emerald transition-colors">Features</a>
                    <a href="#benefits" class="text-firefly hover:text-emerald transition-colors">Benefits</a>
                    <a href="#how-it-works" class="text-firefly hover:text-emerald transition-colors">How It Works</a>
                    <a href="#pricing" class="text-firefly hover:text-emerald transition-colors">Pricing</a>
                    <a href="login.php" class="text-brand-green hover:text-emerald transition-colors font-medium">Log in</a>
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
    <header class="relative min-h-screen flex items-center bg-gradient-to-br from-zircon via-white to-mint/20 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(circle_at_1px_1px,#00D37F_1px,transparent_0)]" style="background-size: 40px 40px;"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 grid lg:grid-cols-2 gap-12 items-center">
            <div class="max-w-xl">
                <div class="mb-8">
                    <span class="inline-block px-4 py-2 rounded-full bg-brand-green/10 text-brand-green font-semibold text-sm mb-4">Stop the Seating Chaos</span>
                    <h1 class="text-5xl sm:text-6xl font-bold tracking-tight mb-6">
                        <span class="block text-firefly">Still Using</span>
                        <span class="block gradient-text">Spreadsheets?</span>
                    </h1>
                    <p class="text-xl text-firefly/80 mb-6">
                        Event seating management is a nightmare. Double bookings, confused guests, and endless email chains are costing you precious time and causing unnecessary stress.
                    </p>
                    <p class="text-xl font-semibold text-brand-green mb-8">
                        There's a better way.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="register.php" class="inline-flex justify-center items-center px-8 py-3 rounded-lg bg-brand-green text-white font-medium hover:bg-emerald transition-colors">
                        Transform Your Events
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#how-it-works" class="inline-flex justify-center items-center px-8 py-3 rounded-lg bg-emerald/10 text-emerald font-medium hover:bg-emerald/20 transition-colors">
                        See How It Works
                    </a>
                </div>
                <div class="mt-8 flex items-center space-x-4 text-firefly/60">
                    <div class="flex -space-x-2">
                        <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=John+D&background=random" alt="User">
                        <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=Sarah+M&background=random" alt="User">
                        <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=Mike+R&background=random" alt="User">
                    </div>
                    <span class="text-sm">Trusted by 1000+ event planners</span>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <div class="absolute inset-0 bg-gradient-to-tr from-emerald/20 to-transparent rounded-3xl"></div>
                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=1200&h=800&q=80" 
                     alt="Professional event seating arrangement" 
                     class="rounded-3xl shadow-2xl w-full h-[600px] object-cover transform hover:scale-[1.02] transition-transform duration-500">
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-brand-green/10 rounded-full filter blur-2xl"></div>
            </div>
        </div>
    </header>

    <!-- Section Divider -->
    <div class="relative">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-emerald/10"></div>
        </div>
        <div class="relative flex justify-center">
            <div class="bg-white px-4 flex items-center space-x-2">
                <div class="w-2 h-2 rounded-full bg-brand-green"></div>
                <div class="w-3 h-3 rounded-full bg-emerald"></div>
                <div class="w-2 h-2 rounded-full bg-brand-green"></div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="inline-block px-4 py-2 rounded-full bg-emerald/10 text-emerald font-semibold text-sm mb-4">The Solution You Need</span>
                <h2 class="text-3xl font-extrabold text-firefly sm:text-4xl">
                    Say Goodbye to Seating Headaches
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-firefly/70 lg:mx-auto">
                    Sitr transforms chaotic spreadsheets into a streamlined system that makes event seating a breeze.
                </p>
            </div>

            <!-- Feature Image Showcase -->
            <div class="mt-12 mb-20 relative">
                <div class="bg-gradient-to-r from-emerald/5 to-brand-green/5 rounded-3xl p-6">
                    <div class="relative">
                        <img src="assets/images/admin-demo.png" alt="Sitr admin interface" class="rounded-2xl shadow-xl w-full">
                        <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-brand-green/10 rounded-full filter blur-2xl"></div>
                        <div class="absolute -top-4 -left-4 w-32 h-32 bg-mint/20 rounded-full filter blur-2xl"></div>
                    </div>
                </div>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature cards with updated styling -->
                    <div class="relative p-6 bg-zircon rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-firefly">Interactive Seating Map</h3>
                            <p class="mt-2 text-firefly/70">
                                Visual, intuitive interface showing real-time seat availability and table layouts.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative p-6 bg-zircon rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-firefly">Guest Management</h3>
                            <p class="mt-2 text-firefly/70">
                                Easily manage companion seating and group arrangements.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative p-6 bg-zircon rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-bell text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-firefly">Real-Time Updates</h3>
                            <p class="mt-2 text-firefly/70">
                                Instant notifications and confirmations for all seating actions.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="relative p-6 bg-zircon rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-lock text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-firefly">Secure System</h3>
                            <p class="mt-2 text-firefly/70">
                                Protected access with email verification and secure authentication.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 5 -->
                    <div class="relative p-6 bg-zircon rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-mobile-alt text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-firefly">Mobile Friendly</h3>
                            <p class="mt-2 text-firefly/70">
                                Fully responsive design works perfectly on all devices.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 6 -->
                    <div class="relative p-6 bg-zircon rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-firefly">24/7 Availability</h3>
                            <p class="mt-2 text-firefly/70">
                                Select and manage seats anytime, anywhere.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="relative -mt-20 mb-20">
        <svg class="w-full h-24 fill-current text-white" viewBox="0 0 1440 74" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,32L60,37.3C120,43,240,53,360,58.7C480,64,600,64,720,58.7C840,53,960,43,1080,37.3C1200,32,1320,32,1380,32L1440,32L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
        </svg>
    </div>

    <!-- Benefits Section -->
    <section id="benefits" class="py-20 bg-gradient-to-br from-zircon to-mint/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="inline-block px-4 py-2 rounded-full bg-brand-green/10 text-brand-green font-semibold text-sm mb-4">The Pain Points We Solve</span>
                <h2 class="text-3xl font-extrabold text-firefly sm:text-4xl">
                    Event Planning Shouldn't Be This Hard
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-firefly/70 lg:mx-auto">
                    We've reimagined event seating management from the ground up
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Problem Card 1 -->
                    <div class="benefit-card bg-white rounded-xl shadow-lg overflow-hidden p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                    <i class="fas fa-exclamation-circle text-lg"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-firefly">Manual Chaos</h3>
                            </div>
                        </div>
                        <p class="mt-4 text-firefly/70">
                            <span class="text-red-500 font-semibold">Before Sitr:</span> Hours spent managing spreadsheets, emails, and phone calls just to handle seating arrangements.
                        </p>
                        <p class="mt-2 text-brand-green font-medium">
                            ↓ Now: Automated system handles everything in minutes
                        </p>
                    </div>

                    <!-- Problem Card 2 -->
                    <div class="benefit-card bg-white rounded-xl shadow-lg overflow-hidden p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                    <i class="fas fa-users-slash text-lg"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-firefly">Guest Confusion</h3>
                            </div>
                        </div>
                        <p class="mt-4 text-firefly/70">
                            <span class="text-red-500 font-semibold">Before Sitr:</span> Guests unsure about their seats, leading to day-of confusion and frustration.
                        </p>
                        <p class="mt-2 text-brand-green font-medium">
                            ↓ Now: Clear, instant confirmations for everyone
                        </p>
                    </div>

                    <!-- Problem Card 3 -->
                    <div class="benefit-card bg-white rounded-xl shadow-lg overflow-hidden p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                    <i class="fas fa-clock text-lg"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-firefly">Last-Minute Changes</h3>
                            </div>
                        </div>
                        <p class="mt-4 text-firefly/70">
                            <span class="text-red-500 font-semibold">Before Sitr:</span> Panic when guests need to change seats or cancel, causing a ripple of manual updates.
                        </p>
                        <p class="mt-2 text-brand-green font-medium">
                            ↓ Now: Real-time updates and flexible changes
                        </p>
                    </div>
                </div>
            </div>

            <!-- Success Stats -->
            <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-3">
                <div class="text-center">
                    <div class="text-4xl font-bold text-brand-green">98%</div>
                    <div class="mt-2 text-firefly">Time Saved vs Manual</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-brand-green">10,000+</div>
                    <div class="mt-2 text-firefly">Events Managed</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-brand-green">4.9/5</div>
                    <div class="mt-2 text-firefly">Customer Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Curved Divider -->
    <div class="relative">
        <svg class="w-full h-24 fill-current text-mint/20" viewBox="0 0 1440 74" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,32L60,37.3C120,43,240,53,360,58.7C480,64,600,64,720,58.7C840,53,960,43,1080,37.3C1200,32,1320,32,1380,32L1440,32L1440,74L1380,74C1320,74,1200,74,1080,74C960,74,840,74,720,74C600,74,480,74,360,74C240,74,120,74,60,74L0,74Z"></path>
        </svg>
    </div>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="inline-block px-4 py-2 rounded-full bg-emerald/10 text-emerald font-semibold text-sm mb-4">Simple & Intuitive</span>
                <h2 class="text-3xl font-extrabold text-firefly sm:text-4xl">
                    Three Steps to Seating Success
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-firefly/70 lg:mx-auto">
                    Transform your event seating from chaos to clarity in minutes
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Step 1 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-brand-green to-mint text-white text-2xl font-bold mx-auto">
                            1
                        </div>
                        <div class="absolute top-10 left-full w-full hidden md:block">
                            <div class="h-0.5 w-full bg-gradient-to-r from-brand-green to-transparent"></div>
                        </div>
                        <h3 class="mt-8 text-xl font-semibold text-firefly text-center">Quick Setup</h3>
                        <p class="mt-2 text-firefly/70 text-center">
                            Create your event in 60 seconds. Import your guest list, set your tables, and you're ready to go.
                        </p>
                        <div class="mt-4 flex justify-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                </svg>
                                60-second setup
                            </span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-brand-green to-mint text-white text-2xl font-bold mx-auto">
                            2
                        </div>
                        <div class="absolute top-10 left-full w-full hidden md:block">
                            <div class="h-0.5 w-full bg-gradient-to-r from-brand-green to-transparent"></div>
                        </div>
                        <h3 class="mt-8 text-xl font-semibold text-firefly text-center">Share & Manage</h3>
                        <p class="mt-2 text-firefly/70 text-center">
                            Send invites with our beautiful interface. Guests select their seats with ease.
                        </p>
                        <div class="mt-4 flex justify-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                </svg>
                                Real-time updates
                            </span>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-brand-green to-mint text-white text-2xl font-bold mx-auto">
                            3
                        </div>
                        <h3 class="mt-8 text-xl font-semibold text-firefly text-center">Relax & Enjoy</h3>
                        <p class="mt-2 text-firefly/70 text-center">
                            Watch as your seating plan comes together automatically. No stress, no mess.
                        </p>
                        <div class="mt-4 flex justify-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                </svg>
                                100% automated
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demo Video Placeholder -->
            <div class="mt-20 relative rounded-2xl overflow-hidden bg-gradient-to-r from-emerald/5 to-brand-green/5 p-8">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="assets/images/seating-demo.png" alt="Sitr Demo" class="rounded-xl shadow-2xl w-full h-full object-cover">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <a href="#" class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white shadow-lg hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-brand-green" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-brand-green/10 rounded-full filter blur-2xl"></div>
                <div class="absolute -top-4 -left-4 w-32 h-32 bg-mint/20 rounded-full filter blur-2xl"></div>
            </div>
        </div>
    </section>

    <!-- Zigzag Divider -->
    <div class="relative">
        <svg class="w-full h-24" viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,0 L1440,0 L1440,48 L0,48 L0,0 Z M1440,48 L1440,0 L0,48 L1440,48 Z" fill="url(#grad1)"></path>
            <defs>
                <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#014751;stop-opacity:0.1" />
                    <stop offset="50%" style="stop-color:#00D37F;stop-opacity:0.1" />
                    <stop offset="100%" style="stop-color:#014751;stop-opacity:0.1" />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gradient-to-br from-zircon to-mint/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="inline-block px-4 py-2 rounded-full bg-brand-green/10 text-brand-green font-semibold text-sm mb-4">Affordable & Transparent</span>
                <h2 class="text-3xl font-extrabold text-firefly sm:text-4xl">
                    Investment That Pays For Itself
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-firefly/70 lg:mx-auto">
                    Save countless hours and eliminate stress with our cost-effective plans
                </p>
            </div>

            <!-- Pricing calculator with updated styling -->
            <div class="mt-12 max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-firefly">ROI Calculator</h3>
                </div>
                <div class="space-y-6">
                    <div class="text-sm text-firefly/70">
                        <p class="mb-2"><span class="font-semibold text-brand-green">Smart Pricing:</span> See how Sitr pays for itself by saving you time and reducing stress!</p>
                    </div>
                    <div>
                        <label for="attendees" class="block text-sm font-medium text-firefly/70">
                            Expected Number of Attendees: <span id="attendeeCount" class="text-brand-green font-semibold">200</span>
                        </label>
                        <input type="range" id="attendees" name="attendees" min="50" max="500" value="200" step="10"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer mt-2">
                    </div>
                    <div class="bg-emerald/10 p-4 rounded-lg">
                        <h4 class="font-medium text-emerald mb-2">How It Works:</h4>
                        <p class="text-sm text-emerald pricing-example">
                            For example, with <span id="pricing-example-attendees">200</span> attendees on our Pro plan:
                        </p>
                        <ul class="mt-2 space-y-2 text-sm text-emerald">
                            <li class="flex items-center">
                                <i class="fas fa-plus text-green-500 mr-2"></i>
                                Add just <span id="exampleCost" class="font-bold"> $1.00 </span> to each ticket price
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

            <!-- Pricing cards with updated styling -->
            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Basic Plan -->
                    <div class="pricing-card bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-emerald">
                        <div class="px-8 py-10">
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-firefly mb-1">Basic</h3>
                                <p class="text-firefly mb-6">Perfect for small events</p>
                                <div class="mb-6">
                                    <div class="flex items-center justify-center">
                                        <span class="text-5xl font-bold text-firefly">$99</span>
                                        <span class="text-firefly ml-2">/event</span>
                                    </div>
                                    <div class="mt-4" id="basicPriceContainer">
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                            <div class="flex items-center justify-center text-green-800">
                                                <i class="fas fa-magic text-green-600 mr-2"></i>
                                                <span>
                                                    Add just <span id="basicPerTicket" class="font-semibold">$1.65</span> per ticket<br/>to cover the entire cost!
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="border-t border-gray-100 pt-6 mb-6"></div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Up to 100 guests</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Interactive seating map</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Real-time updates</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Email support</span>
                                </div>
                            </div>
                            <div class="mt-8">
                                <a href="register.php" class="block w-full text-center px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                                    Get Started
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pro Plan -->
                    <div class="pricing-card bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-emerald transform scale-105 relative">
                        <div class="absolute top-0 right-0 mt-4 mr-4">
                            <span class="bg-emerald text-white text-sm px-3 py-1 rounded-full font-medium">Popular</span>
                        </div>
                        <div class="px-8 py-10">
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-firefly mb-1">Pro</h3>
                                <p class="text-firefly mb-6">For medium-sized events</p>
                                <div class="mb-6">
                                    <div class="flex items-center justify-center">
                                        <span class="text-5xl font-bold text-firefly">$199</span>
                                        <span class="text-firefly ml-2">/event</span>
                                    </div>
                                    <div class="mt-4" id="proPriceContainer">
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                            <div class="flex items-center justify-center text-green-800">
                                                <i class="fas fa-magic text-green-600 mr-2"></i>
                                                <span>
                                                    Add just <span id="proPerTicket" class="font-semibold">$2.65</span> per ticket<br/>to cover the entire cost!
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="border-t border-gray-100 pt-6 mb-6"></div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Up to 300 guests</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">All Basic features</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Guest management tools</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Priority support</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Custom branding</span>
                                </div>
                            </div>
                            <div class="mt-8">
                                <a href="register.php" class="block w-full text-center px-6 py-3 bg-emerald text-white rounded-lg hover:bg-emerald transition-colors font-medium">
                                    Get Started
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="pricing-card bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-gray-800 transition-transform hover:scale-[1.02]">
                        <div class="px-8 py-10">
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-firefly mb-1">Enterprise</h3>
                                <p class="text-firefly mb-6">For large events</p>
                                <div class="mb-6">
                                    <div class="flex items-center justify-center">
                                        <span class="text-5xl font-bold text-firefly">Custom</span>
                                    </div>
                                    <div class="mt-4" id="enterprisePriceContainer">
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                            <div class="flex items-center justify-center text-green-800">
                                                <i class="fas fa-magic text-green-600 mr-2"></i>
                                                <span>
                                                    Add just <span id="enterprisePerTicket" class="font-semibold">$3.65</span> per ticket<br/>to cover the entire cost!
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="border-t border-gray-100 pt-6 mb-6"></div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Unlimited guests</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">All Pro features</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Dedicated support</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Custom integrations</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3 w-5"></i>
                                    <span class="text-firefly">Advanced analytics</span>
                                </div>
                            </div>
                            <div class="mt-8">
                                <a href="register.php" class="block w-full text-center px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                                    Contact Sales
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Wavy Divider -->
    <div class="relative">
        <svg class="w-full h-24" viewBox="0 0 1440 74" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,37.3C48,46.7,144,74,240,74C336,74,432,46.7,528,37.3C624,28,720,37.3,816,42C912,46.7,1008,46.7,1104,42C1200,37.3,1296,28,1344,23.3L1392,18.7L1440,14L1440,0L0,0Z" fill="url(#grad2)"></path>
            <defs>
                <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#014751;stop-opacity:0.1" />
                    <stop offset="50%" style="stop-color:#00D37F;stop-opacity:0.1" />
                    <stop offset="100%" style="stop-color:#014751;stop-opacity:0.1" />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-emerald to-brand-green">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    <span class="block">Ready to End Seating Chaos?</span>
                    <span class="block text-mint mt-2">Join 1000+ Event Planners Who Love Sitr</span>
                </h2>
                <p class="mt-4 text-lg text-white/80">
                    Start your journey to stress-free event planning today. Set up your first event in just 60 seconds!
                </p>
            </div>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0 space-x-4">
                <a href="register.php" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-emerald bg-white hover:bg-zircon transition-all transform hover:scale-105">
                    Get Started Free
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="#how-it-works" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-lg font-medium rounded-lg text-white hover:bg-white/10 transition-all">
                    See How It Works
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-firefly">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="mt-8 border-t border-emerald/20 pt-8 md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <p class="text-base text-mint">
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
        const pricingExampleAttendees = document.querySelector('#pricing #pricing-example-attendees');
        const exampleCost = document.getElementById('exampleCost');

        function updatePricing() {
            const attendees = parseInt(attendeeSlider.value);
            attendeeCount.textContent = attendees;
            if (pricingExampleAttendees) {
                pricingExampleAttendees.textContent = attendees;
            }

            // Calculate per-ticket costs
            const basicCost = (99 / attendees).toFixed(2);
            const proCost = (199 / attendees).toFixed(2);
            const enterpriseCost = ((299 + (attendees * 0.25)) / attendees).toFixed(2);

            // Update display for Basic plan
            const basicPriceContainer = document.querySelector('#basicPriceContainer');
            if (attendees > 100) {
                basicPriceContainer.innerHTML = `<span class="text-red-500">Exceeds plan limit<br/>(max 100 attendees)</span>`;
            } else {
                basicPriceContainer.innerHTML = `
                    <div class="bg-green-50 border border-green-200 rounded-lg p-2 flex items-center">
                        <i class="fas fa-magic text-green-500 mr-2"></i>
                        <span class="text-green-800">
                            Add just <span id="basicPerTicket" class="font-semibold">$${basicCost}</span> per ticket to cover the entire cost!
                        </span>
                    </div>`;
            }

            // Update display for Pro plan
            const proPriceContainer = document.querySelector('#proPriceContainer');
            if (attendees > 300) {
                proPriceContainer.innerHTML = `<span class="text-red-500">Exceeds plan limit<br/>(max 300 attendees)</span>`;
            } else {
                proPriceContainer.innerHTML = `
                    <div class="bg-green-50 border border-green-200 rounded-lg p-2 flex items-center">
                        <i class="fas fa-magic text-green-500 mr-2"></i>
                        <span class="text-green-800">
                            Add just <span id="proPerTicket" class="font-semibold">$${proCost}</span> per ticket to cover the entire cost!
                        </span>
                    </div>`;
            }

            // Always update Enterprise plan since it has no limit
            const enterprisePriceContainer = document.querySelector('#enterprisePriceContainer');
            enterprisePriceContainer.innerHTML = `
                <div class="bg-green-50 border border-green-200 rounded-lg p-2 flex items-center">
                    <i class="fas fa-magic text-green-500 mr-2"></i>
                    <span class="text-green-800">
                        Add just <span id="enterprisePerTicket" class="font-semibold">$${enterpriseCost}</span> per ticket to cover the entire cost!
                    </span>
                </div>`;

            // Update the example text and cost
            document.querySelector('#pricing .bg-emerald\\/10 .text-emerald').innerHTML = `
                For example, with <span id="pricing-example-attendees">${attendees}</span> attendees on our ${attendees <= 100 ? 'Basic' : attendees <= 300 ? 'Pro' : 'Enterprise'} plan:
            `;
            exampleCost.textContent = `$${attendees <= 100 ? basicCost : attendees <= 300 ? proCost : enterpriseCost}`;
        }

        attendeeSlider.addEventListener('input', updatePricing);
        updatePricing(); // Initial calculation
    </script>
</body>
</html> 