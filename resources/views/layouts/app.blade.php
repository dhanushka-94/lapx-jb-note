<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Job Note') }}</title>
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
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div id="app" class="flex flex-col min-h-screen">
        @if(!(request()->is('login')))
        <!-- Sidebar for larger screens and navbar for mobile -->
        <div class="flex h-screen">
            <!-- Sidebar (visible on md and up) -->
            <div class="hidden md:flex md:flex-col md:w-64 md:fixed md:inset-y-0 bg-indigo-700 text-white shadow-xl">
                <div class="p-6 flex items-center justify-center">
                    <a href="{{ url('/dashboard') }}" class="text-2xl font-bold tracking-tight text-white">
                        <i class="fas fa-laptop-medical mr-2"></i>{{ config('app.name', 'Job Note') }}
                    </a>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-4 py-4 space-y-2">
                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="{{ request()->routeIs('dashboard') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }} flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 hover:pl-6">
                                <i class="fas fa-tachometer-alt w-6 mr-3 text-center"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('customers.index') }}" 
                               class="{{ request()->routeIs('customers.*') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }} flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 hover:pl-6">
                                <i class="fas fa-users w-6 mr-3 text-center"></i>
                                Customers
                            </a>
                            <a href="{{ route('jobs.index') }}" 
                               class="{{ request()->routeIs('jobs.*') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }} flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 hover:pl-6">
                                <i class="fas fa-clipboard-list w-6 mr-3 text-center"></i>
                                Jobs
                            </a>
                            <a href="{{ route('users.index') }}" 
                               class="{{ request()->routeIs('users.*') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }} flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 hover:pl-6">
                                <i class="fas fa-user-cog w-6 mr-3 text-center"></i>
                                Users
                            </a>
                        @endauth
                    </nav>

                    @auth
                    <div class="px-4 py-6 border-t border-indigo-600">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold shadow-md">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-indigo-200 hover:text-white transition-colors duration-200 flex items-center mt-1">
                                        <i class="fas fa-sign-out-alt text-xs mr-1"></i> Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile header (visible on small screens) -->
            <div class="md:hidden bg-indigo-700 w-full fixed top-0 z-10">
                <div class="flex items-center justify-between h-16 px-4">
                    <div class="flex items-center">
                        <a href="{{ url('/dashboard') }}" class="text-xl font-bold text-white">
                            <i class="fas fa-laptop-medical mr-2"></i>{{ config('app.name', 'Job Note') }}
                        </a>
                    </div>
                    @auth
                    <div class="flex items-center">
                        <button id="mobile-menu-button" class="text-white focus:outline-none">
                            <i class="fas fa-bars h-6 w-6"></i>
                        </button>
                    </div>
                    @endauth
                </div>

                <!-- Mobile menu (hidden by default) -->
                @auth
                <div id="mobile-menu" class="hidden bg-indigo-800 px-2 py-2">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-600 transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('customers.index') }}" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-600 transition-colors duration-200">
                        <i class="fas fa-users mr-2"></i>Customers
                    </a>
                    <a href="{{ route('jobs.index') }}" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-600 transition-colors duration-200">
                        <i class="fas fa-clipboard-list mr-2"></i>Jobs
                    </a>
                    <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-600 transition-colors duration-200">
                        <i class="fas fa-user-cog mr-2"></i>Users
                    </a>
                    <div class="border-t border-indigo-600 mt-2 pt-2">
                        <p class="px-3 py-1 text-xs text-indigo-200">{{ Auth::user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="px-3">
                            @csrf
                            <button type="submit" class="py-1 text-xs text-indigo-200 hover:text-white transition-colors duration-200 flex items-center">
                                <i class="fas fa-sign-out-alt mr-1"></i> Sign out
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>

            <!-- Main content -->
            <main class="flex-1 md:ml-64 pt-5 md:pt-5 pb-10 px-4 md:px-8">
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