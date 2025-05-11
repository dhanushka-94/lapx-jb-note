<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Job Note') }}</title>
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Heroicons (for icons) -->
    <script src="https://unpkg.com/heroicons@1.0.4/outline/index.js"></script>
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
                        {{ config('app.name', 'Job Note') }}
                    </a>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-4 py-4 space-y-2">
                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="{{ request()->routeIs('dashboard') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }} flex items-center px-4 py-3 text-white rounded-lg transition-colors duration-200">
                                <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('users.index') }}" 
                               class="{{ request()->routeIs('users.*') ? 'bg-indigo-800' : 'hover:bg-indigo-600' }} flex items-center px-4 py-3 text-white rounded-lg transition-colors duration-200">
                                <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Users
                            </a>
                        @endauth
                    </nav>

                    @auth
                    <div class="px-4 py-6 border-t border-indigo-600">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-indigo-200 hover:text-white transition-colors duration-200">
                                        Sign out
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
                            {{ config('app.name', 'Job Note') }}
                        </a>
                    </div>
                    @auth
                    <div class="flex items-center">
                        <button id="mobile-menu-button" class="text-white focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    @endauth
                </div>

                <!-- Mobile menu (hidden by default) -->
                @auth
                <div id="mobile-menu" class="hidden bg-indigo-800 px-2 py-2">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-600 transition-colors duration-200">Dashboard</a>
                    <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-md text-white hover:bg-indigo-600 transition-colors duration-200">Users</a>
                    <div class="border-t border-indigo-600 mt-2 pt-2">
                        <p class="px-3 py-1 text-xs text-indigo-200">{{ Auth::user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="px-3">
                            @csrf
                            <button type="submit" class="py-1 text-xs text-indigo-200 hover:text-white transition-colors duration-200">
                                Sign out
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
                                    <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
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
                                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
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