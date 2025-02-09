<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitr for Corporate Training - Professional Seating Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #2563EB, #1E40AF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .feature-icon {
            background: linear-gradient(135deg, #2563EB, #1E40AF);
        }
        .hero-glow-1 {
            background: #2563EB;
            top: -100px;
            right: -100px;
        }
        .hero-glow-2 {
            background: #1E40AF;
            bottom: -100px;
            left: -100px;
        }
    </style>
</head>
<body class="bg-blue-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="#" class="text-2xl font-bold text-blue-600">Sitr</a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-blue-600 transition-colors">Features</a>
                    <a href="#benefits" class="text-gray-700 hover:text-blue-600 transition-colors">Benefits</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-blue-600 transition-colors">How It Works</a>
                    <a href="#pricing" class="text-gray-700 hover:text-blue-600 transition-colors">Pricing</a>
                    <a href="login.php" class="text-blue-600 hover:text-blue-700 transition-colors font-medium">Log in</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with PAS Framework -->
    <header class="relative min-h-screen flex items-center bg-gradient-to-br from-blue-50 via-white to-blue-50/20 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(circle_at_1px_1px,#2563EB_1px,transparent_0)]" style="background-size: 40px 40px;"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 grid lg:grid-cols-2 gap-12 items-center">
            <div class="max-w-xl">
                <!-- Problem -->
                <div class="mb-8">
                    <span class="inline-block px-4 py-2 rounded-full bg-blue-100 text-blue-600 font-semibold text-sm mb-4">Training ROI Issues?</span>
                    <h2 class="text-2xl text-gray-900 mb-4">
                        Is poor seating killing your training effectiveness?
                    </h2>
                    
                    <!-- Agitate -->
                    <div class="space-y-4 mb-6">
                        <p class="text-gray-600">
                            <i class="fas fa-times text-blue-500 mr-2"></i>
                            Departments sitting in silos, limiting cross-functional learning
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-times text-blue-500 mr-2"></i>
                            Disengaged participants due to random seating arrangements
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-times text-blue-500 mr-2"></i>
                            Wasted training budget due to ineffective group dynamics
                        </p>
                    </div>

                    <!-- Solution -->
                    <h1 class="text-5xl sm:text-6xl font-bold tracking-tight mb-6">
                        <span class="block text-gray-900">Maximize Your</span>
                        <span class="block gradient-text">Training Impact</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-6">
                        Transform your corporate training with strategic seating that boosts engagement, facilitates knowledge sharing, and delivers measurable ROI.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="register.php" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            Schedule Demo
                        </a>
                        <a href="#how-it-works" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-check text-blue-600 mr-2"></i>
                        SOC 2 Compliant
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check text-blue-600 mr-2"></i>
                        Enterprise Support
                    </div>
                </div>
            </div>
            <div class="relative">
                <img src="assets/images/corporate-training.jpg" alt="Corporate Training Setup" 
                    class="rounded-3xl shadow-2xl w-full h-[600px] object-cover transform hover:scale-[1.02] transition-transform duration-500">
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-200/50 rounded-full filter blur-2xl"></div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="inline-block px-4 py-2 rounded-full bg-blue-100 text-blue-600 font-semibold text-sm mb-4">Enterprise Features</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Built for Corporate Training Success
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 lg:mx-auto">
                    Powerful features designed specifically for corporate training events and professional development programs.
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="relative p-6 bg-blue-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-users-cog text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Team-Based Grouping</h3>
                            <p class="mt-2 text-gray-600">
                                Automatically arrange seating by department, team, or role for optimal collaboration.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative p-6 bg-blue-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-file-export text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Export & Reporting</h3>
                            <p class="mt-2 text-gray-600">
                                Generate detailed seating reports and export data for your records.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative p-6 bg-blue-50 rounded-xl hover:shadow-lg transition-all">
                        <div class="absolute -top-4 left-6">
                            <div class="feature-icon w-12 h-12 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-shield-alt text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900">Enterprise Security</h3>
                            <p class="mt-2 text-gray-600">
                                SOC 2 compliant with SSO integration and role-based access control.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Transform Your Training Events?</h2>
            <p class="text-xl mb-8">Join leading companies using Sitr for their corporate training programs.</p>
            <a href="register.php" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-blue-600 bg-white hover:bg-blue-50 transition-colors">
                Schedule Demo
            </a>
        </div>
    </section>
</body>
</html> 