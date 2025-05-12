<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laptop Expert (Pvt) Ltd - Service Center') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom styles -->
    <style>
        .btn-effect:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        :root {
            --dark-blue: #0a2463;
            --medium-blue: #1e40af;
            --light-blue: #e9f0fd;
        }
        
        /* Global form input styles */
        .form-input,
        .form-select,
        .form-textarea,
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        input[type="date"],
        input[type="tel"],
        input[type="search"],
        select,
        textarea {
            padding-top: 0.625rem;
            padding-bottom: 0.625rem;
            height: auto;
            min-height: 2.75rem;
        }
        
        textarea.form-textarea,
        textarea {
            min-height: 6rem;
        }
        
        /* Button standardization */
        .form-button,
        button[type="submit"],
        button[type="button"] {
            min-height: 2.75rem;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div id="app" class="flex flex-col min-h-screen">
        @if(!(request()->is('login')))
        <!-- Sidebar for larger screens and navbar for mobile -->
        <div class="flex h-screen">
            <!-- Sidebar (visible on md and up) -->
            <div class="hidden md:flex md:flex-col md:w-64 md:fixed md:inset-y-0 bg-white text-gray-700 shadow-lg border-r border-gray-100">
                <!-- Logo Section -->
                <div class="p-6 flex flex-col items-center justify-center bg-[#0a2463]">
                    <a href="{{ url('/dashboard') }}" class="flex flex-col items-center">
                        <img src="{{ asset('logo-white.png') }}" alt="Logo" class="h-14">
                        <div class="mt-3 text-white font-semibold text-center">
                            <span>Laptop Expert (Pvt) Ltd</span><br>
                            <span>Service Center</span>
                        </div>
                    </a>
                </div>
                
                <!-- Navigation Section -->
                <div class="flex-1 flex flex-col overflow-y-auto pt-5 pb-4 px-3">
                    <nav class="flex-1 space-y-1">
                        @auth
                            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-3 mb-2">Main</p>
                            
                            <a href="{{ route('dashboard') }}" 
                               class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2463]' }} 
                                  group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-all duration-200">
                                <i class="fas fa-tachometer-alt w-6 mr-3 text-center {{ request()->routeIs('dashboard') ? 'text-[#0a2463]' : 'text-gray-400 group-hover:text-[#0a2463]' }}"></i>
                                Dashboard
                            </a>
                            
                            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Management</p>
                            
                            <a href="{{ route('customers.index') }}" 
                               class="{{ request()->routeIs('customers.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2463]' }} 
                                  group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-all duration-200">
                                <i class="fas fa-users w-6 mr-3 text-center {{ request()->routeIs('customers.*') ? 'text-[#0a2463]' : 'text-gray-400 group-hover:text-[#0a2463]' }}"></i>
                                Customers
                            </a>
                            
                            <a href="{{ route('jobs.index') }}" 
                               class="{{ request()->routeIs('jobs.*') && !request()->routeIs('jobs.highlights') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2463]' }} 
                                  group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-all duration-200">
                                <i class="fas fa-clipboard-list w-6 mr-3 text-center {{ request()->routeIs('jobs.*') && !request()->routeIs('jobs.highlights') ? 'text-[#0a2463]' : 'text-gray-400 group-hover:text-[#0a2463]' }}"></i>
                                Jobs
                            </a>
                            
                            <a href="{{ route('jobs.highlights') }}" 
                               class="{{ request()->routeIs('jobs.highlights') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2463]' }} 
                                  group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-all duration-200">
                                <i class="fas fa-exclamation-circle w-6 mr-3 text-center {{ request()->routeIs('jobs.highlights') ? 'text-[#0a2463]' : 'text-gray-400 group-hover:text-[#0a2463]' }}"></i>
                                Job Highlights
                            </a>
                            
                            <a href="{{ route('users.index') }}" 
                               class="{{ request()->routeIs('users.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2463]' }} 
                                  group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-all duration-200">
                                <i class="fas fa-users w-6 mr-3 text-center {{ request()->routeIs('users.*') ? 'text-[#0a2463]' : 'text-gray-400 group-hover:text-[#0a2463]' }}"></i>
                                Users
                            </a>
                            
                            <a href="{{ route('technicians.index') }}" 
                               class="{{ request()->routeIs('technicians.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2463]' }} 
                                  group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-all duration-200">
                                <i class="fas fa-wrench w-6 mr-3 text-center {{ request()->routeIs('technicians.*') ? 'text-[#0a2463]' : 'text-gray-400 group-hover:text-[#0a2463]' }}"></i>
                                Technicians
                            </a>
                            
                            <a href="{{ route('sms-logs.index') }}" 
                               class="{{ request()->routeIs('sms-logs.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2463]' }} 
                                  group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-all duration-200">
                                <i class="fas fa-sms w-6 mr-3 text-center {{ request()->routeIs('sms-logs.*') ? 'text-[#0a2463]' : 'text-gray-400 group-hover:text-[#0a2463]' }}"></i>
                                SMS Logs
                            </a>
                            
                            <a href="{{ route('reports.index') }}" 
                               class="{{ request()->routeIs('reports.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2463]' }} 
                                  group flex items-center px-3 py-3 text-sm font-medium rounded-md transition-all duration-200">
                                <i class="fas fa-chart-bar w-6 mr-3 text-center {{ request()->routeIs('reports.*') ? 'text-[#0a2463]' : 'text-gray-400 group-hover:text-[#0a2463]' }}"></i>
                                Reports
                            </a>
                        @endauth
                    </nav>
                </div>

                <!-- User Profile Section -->
                @auth
                <div class="px-4 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-9 w-9 rounded-full bg-[#0a2463] flex items-center justify-center text-white font-bold shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="text-xs text-gray-500 hover:text-[#0a2463] transition-colors duration-200 flex items-center">
                                    <i class="fas fa-sign-out-alt text-xs mr-1"></i> Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>

            <!-- Mobile header (visible on small screens) -->
            <div class="md:hidden bg-white w-full fixed top-0 z-10 border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between h-16 px-4">
                    <div class="flex items-center">
                        <a href="{{ url('/dashboard') }}" class="flex items-center">
                            <div class="bg-[#0a2463] p-2 rounded">
                                <img src="{{ asset('logo-white.png') }}" alt="Logo" class="h-8">
                            </div>
                            <span class="ml-2 text-sm font-semibold">Laptop Expert</span>
                        </a>
                    </div>
                    @auth
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        <button id="mobile-menu-button" class="text-gray-700 focus:outline-none bg-gray-100 p-2 rounded-md">
                            <i class="fas fa-bars h-5 w-5"></i>
                        </button>
                    </div>
                    @endauth
                </div>

                <!-- Mobile menu (hidden by default) -->
                @auth
                <div id="mobile-menu" class="hidden bg-white px-2 py-2 border-b border-gray-200 shadow-sm">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1">
                        <i class="fas fa-tachometer-alt w-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-[#0a2463]' : 'text-gray-400' }}"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1">
                        <i class="fas fa-users w-5 mr-3 {{ request()->routeIs('customers.*') ? 'text-[#0a2463]' : 'text-gray-400' }}"></i>
                        Customers
                    </a>
                    <a href="{{ route('jobs.index') }}" class="{{ request()->routeIs('jobs.*') && !request()->routeIs('jobs.highlights') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1">
                        <i class="fas fa-clipboard-list w-5 mr-3 {{ request()->routeIs('jobs.*') && !request()->routeIs('jobs.highlights') ? 'text-[#0a2463]' : 'text-gray-400' }}"></i>
                        Jobs
                    </a>
                    <a href="{{ route('jobs.highlights') }}" class="{{ request()->routeIs('jobs.highlights') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1">
                        <i class="fas fa-exclamation-circle w-5 mr-3 {{ request()->routeIs('jobs.highlights') ? 'text-[#0a2463]' : 'text-gray-400' }}"></i>
                        Job Highlights
                    </a>
                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1">
                        <i class="fas fa-users w-5 mr-3 {{ request()->routeIs('users.*') ? 'text-[#0a2463]' : 'text-gray-400' }}"></i>
                        Users
                    </a>
                    <a href="{{ route('technicians.index') }}" class="{{ request()->routeIs('technicians.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1">
                        <i class="fas fa-wrench w-5 mr-3 {{ request()->routeIs('technicians.*') ? 'text-[#0a2463]' : 'text-gray-400' }}"></i>
                        Technicians
                    </a>
                    <a href="{{ route('sms-logs.index') }}" class="{{ request()->routeIs('sms-logs.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1">
                        <i class="fas fa-sms w-5 mr-3 {{ request()->routeIs('sms-logs.*') ? 'text-[#0a2463]' : 'text-gray-400' }}"></i>
                        SMS Logs
                    </a>
                    <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'bg-blue-50 text-[#0a2463]' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-3 py-3 text-sm font-medium rounded-md mb-1">
                        <i class="fas fa-chart-bar w-5 mr-3 {{ request()->routeIs('reports.*') ? 'text-[#0a2463]' : 'text-gray-400' }}"></i>
                        Reports
                    </a>
                    <div class="border-t border-gray-200 mt-2 pt-3 pb-1">
                        <form method="POST" action="{{ route('logout') }}" class="px-3">
                            @csrf
                            <button type="submit" class="py-1 text-xs text-gray-500 hover:text-[#0a2463] transition-colors duration-200 flex items-center">
                                <i class="fas fa-sign-out-alt mr-1"></i> Sign out
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>

            <!-- Main content -->
            <main class="flex-1 md:ml-64 pt-5 md:pt-5 pb-10 px-4 md:px-8 bg-gray-50">
                <div class="max-w-7xl mx-auto mt-16 md:mt-0">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p>{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p>{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
                
                <!-- Developer Credit Footer -->
                <div class="mt-10 pt-4 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-500">
                        &copy; {{ date('Y') }} Laptop Expert (Pvt) Ltd. All rights reserved. <br>
                        <span class="text-gray-400">Developed by olexto Digital Solutions (Pvt) Ltd</span>
                    </p>
                </div>
            </main>
        </div>
        @else
            <main class="flex-1">
                @yield('content')
            </main>
        @endif
    </div>

    <script>
        // Toggle mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html> 