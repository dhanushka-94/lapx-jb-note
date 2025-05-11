@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</h1>
    <p class="text-gray-600 mt-1">Welcome to your computer service center management system</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Users Stats Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Users</h3>
            <span class="flex items-center justify-center bg-indigo-100 h-10 w-10 rounded-full shadow-sm">
                <i class="fas fa-user-cog text-lg text-indigo-600"></i>
            </span>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="bg-green-100 py-1 px-3 rounded-full shadow-sm">
                    <span class="text-xs font-medium text-green-800">Staff</span>
                </div>
            </div>
            <a href="{{ route('users.index') }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded transition-all duration-200 btn-effect">
                <i class="fas fa-users-cog mr-1"></i> Manage Users
            </a>
        </div>
    </div>

    <!-- Customers Stats Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Customers</h3>
            <span class="flex items-center justify-center bg-blue-100 h-10 w-10 rounded-full shadow-sm">
                <i class="fas fa-users text-lg text-blue-600"></i>
            </span>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Customer::count() }}</p>
                </div>
                <div class="bg-blue-100 py-1 px-3 rounded-full shadow-sm">
                    <span class="text-xs font-medium text-blue-800">Clients</span>
                </div>
            </div>
            <a href="{{ route('customers.index') }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-all duration-200 btn-effect">
                <i class="fas fa-user-plus mr-1"></i> Manage Customers
            </a>
        </div>
    </div>

    <!-- Jobs Stats Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Jobs</h3>
            <span class="flex items-center justify-center bg-green-100 h-10 w-10 rounded-full shadow-sm">
                <i class="fas fa-clipboard-list text-lg text-green-600"></i>
            </span>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Jobs</p>
                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Job::count() }}</p>
                </div>
                <div class="bg-yellow-100 py-1 px-3 rounded-full shadow-sm">
                    <span class="text-xs font-medium text-yellow-800"><i class="fas fa-clock mr-1"></i>{{ \App\Models\Job::where('status', 'pending')->count() }} pending</span>
                </div>
            </div>
            <a href="{{ route('jobs.index') }}" class="block text-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded transition-all duration-200 btn-effect">
                <i class="fas fa-tasks mr-1"></i> Manage Jobs
            </a>
        </div>
    </div>

    <!-- Revenue Stats Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Revenue</h3>
            <span class="flex items-center justify-center bg-purple-100 h-10 w-10 rounded-full shadow-sm">
                <i class="fas fa-dollar-sign text-lg text-purple-600"></i>
            </span>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-800">${{ number_format(\App\Models\Job::sum('cost'), 2) }}</p>
                </div>
                <div class="bg-purple-100 py-1 px-3 rounded-full shadow-sm">
                    <span class="text-xs font-medium text-purple-800"><i class="fas fa-calendar-alt mr-1"></i>This Month</span>
                </div>
            </div>
            <a href="{{ route('jobs.index') }}" class="block text-center bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded transition-all duration-200 btn-effect">
                <i class="fas fa-chart-line mr-1"></i> View Details
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Jobs -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800"><i class="fas fa-history mr-2"></i>Recent Jobs</h3>
        </div>
        <div class="px-6 py-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach(\App\Models\Job::with('customer')->latest()->take(5)->get() as $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><i class="fas fa-hashtag text-xs text-gray-500 mr-1"></i>{{ $job->job_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><i class="fas fa-user text-xs text-gray-500 mr-1"></i>{{ $job->customer->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'waiting_for_parts' => 'bg-purple-100 text-purple-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'delivered' => 'bg-indigo-100 text-indigo-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Pending',
                                        'in_progress' => 'In Progress',
                                        'waiting_for_parts' => 'Waiting for Parts',
                                        'completed' => 'Completed',
                                        'delivered' => 'Delivered',
                                        'cancelled' => 'Cancelled',
                                    ];
                                    $statusIcons = [
                                        'pending' => 'fa-clock',
                                        'in_progress' => 'fa-spinner fa-spin',
                                        'waiting_for_parts' => 'fa-truck-loading',
                                        'completed' => 'fa-check-circle',
                                        'delivered' => 'fa-truck',
                                        'cancelled' => 'fa-times-circle',
                                    ];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm {{ $statusColors[$job->status] }}">
                                    <i class="fas {{ $statusIcons[$job->status] }} mr-1"></i> {{ $statusLabels[$job->status] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500"><i class="fas fa-calendar-day text-xs mr-1"></i>{{ $job->received_date->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                    View all jobs <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Customers -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800"><i class="fas fa-users mr-2"></i>Recent Customers</h3>
        </div>
        <div class="px-6 py-4">
            <ul class="divide-y divide-gray-200">
                @foreach(\App\Models\Customer::latest()->take(5)->get() as $customer)
                <li class="py-3 flex items-center hover:bg-gray-50 px-2 rounded">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold shadow-sm">
                        {{ substr($customer->name, 0, 1) }}
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $customer->name }}</h4>
                                <p class="text-sm text-gray-500 flex items-center"><i class="fas fa-envelope text-xs mr-1"></i>{{ $customer->email }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 flex items-center"><i class="fas fa-clock text-xs mr-1"></i>{{ $customer->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="mt-4 text-center">
                <a href="{{ route('customers.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                    View all customers <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 