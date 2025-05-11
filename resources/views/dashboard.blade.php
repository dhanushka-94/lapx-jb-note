@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600 mt-1">Welcome to your job notes management system</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Users Stats Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">User Management</h3>
            <span class="flex items-center justify-center bg-indigo-100 h-8 w-8 rounded-full">
                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </span>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="bg-green-100 py-1 px-3 rounded-full">
                    <span class="text-xs font-medium text-green-800">Active</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">Manage all users in the system with full CRUD capabilities.</p>
            <a href="{{ route('users.index') }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded transition-colors duration-200">
                Manage Users
            </a>
        </div>
    </div>

    <!-- Activity Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
            <span class="flex items-center justify-center bg-blue-100 h-8 w-8 rounded-full">
                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
        </div>
        <div class="px-6 py-4">
            <ul class="divide-y divide-gray-200">
                <li class="py-3 flex items-start">
                    <span class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                        <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-800">New user created</p>
                        <p class="text-xs text-gray-500">{{ now()->subHours(2)->format('F j, Y \a\t g:i a') }}</p>
                    </div>
                </li>
                <li class="py-3 flex items-start">
                    <span class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-800">System updated</p>
                        <p class="text-xs text-gray-500">{{ now()->subDays(1)->format('F j, Y \a\t g:i a') }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- System Info Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">System Info</h3>
            <span class="flex items-center justify-center bg-purple-100 h-8 w-8 rounded-full">
                <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
        </div>
        <div class="px-6 py-4">
            <ul class="divide-y divide-gray-200">
                <li class="py-2 flex justify-between">
                    <span class="text-sm text-gray-600">Laravel Version</span>
                    <span class="text-sm font-medium text-gray-900">{{ app()->version() }}</span>
                </li>
                <li class="py-2 flex justify-between">
                    <span class="text-sm text-gray-600">PHP Version</span>
                    <span class="text-sm font-medium text-gray-900">{{ phpversion() }}</span>
                </li>
                <li class="py-2 flex justify-between">
                    <span class="text-sm text-gray-600">Environment</span>
                    <span class="text-sm font-medium text-gray-900">{{ app()->environment() }}</span>
                </li>
                <li class="py-2 flex justify-between">
                    <span class="text-sm text-gray-600">Database</span>
                    <span class="text-sm font-medium text-gray-900">{{ config('database.connections.'.config('database.default').'.driver') }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection 