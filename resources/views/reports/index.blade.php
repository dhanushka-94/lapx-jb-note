@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Service Center Reports</h1>
            <p class="text-gray-600 mt-1">Overview of service center performance and metrics</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Jobs</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalJobs }}</p>
            </div>
            <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Customers</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalCustomers }}</p>
            </div>
            <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center text-green-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-800">LKR {{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500">Jobs This Month</p>
                <p class="text-2xl font-bold text-gray-800">{{ $jobsThisMonth }}</p>
            </div>
            <div class="h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Jobs by Status -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Jobs by Status</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
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
                @endphp
                
                @foreach($statusLabels as $status => $label)
                    <div class="flex items-center">
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            @php
                                $count = $jobsByStatus[$status] ?? 0;
                                $percentage = $totalJobs > 0 ? ($count / $totalJobs) * 100 : 0;
                            @endphp
                            <div class="{{ str_replace('text', 'bg', $statusColors[$status]) }} h-4 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="ml-3 min-w-[120px] flex items-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$status] }}">
                                {{ $label }}
                            </span>
                            <span class="ml-2 text-sm text-gray-500">{{ $count ?? 0 }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Jobs by Device Type -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Jobs by Device Type</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @php
                    $deviceColors = [
                        'Laptop' => 'bg-blue-600',
                        'Desktop' => 'bg-green-600',
                        'Tablet' => 'bg-yellow-600',
                        'Mobile Phone' => 'bg-purple-600',
                        'Printer' => 'bg-red-600',
                        'Monitor' => 'bg-indigo-600',
                        'Other' => 'bg-gray-600',
                    ];
                @endphp
                
                @foreach($jobsByDeviceType as $deviceType => $count)
                    <div class="flex items-center">
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            @php
                                $percentage = $totalJobs > 0 ? ($count / $totalJobs) * 100 : 0;
                                $color = $deviceColors[$deviceType] ?? 'bg-gray-600';
                            @endphp
                            <div class="{{ $color }} h-4 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="ml-3 min-w-[120px] flex justify-between">
                            <span class="text-sm font-medium text-gray-600">{{ $deviceType }}</span>
                            <span class="text-sm text-gray-500">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Time Period Stats -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Performance by Time Period</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="rounded-lg bg-gray-50 p-4">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Today</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Jobs</p>
                        <p class="text-xl font-bold text-gray-800">{{ $jobsToday }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Revenue</p>
                        <p class="text-xl font-bold text-gray-800">LKR {{ number_format($revenueToday, 0) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="rounded-lg bg-gray-50 p-4">
                <h4 class="text-sm font-medium text-gray-500 mb-2">This Week</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Jobs</p>
                        <p class="text-xl font-bold text-gray-800">{{ $jobsThisWeek }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Revenue</p>
                        <p class="text-xl font-bold text-gray-800">LKR {{ number_format($revenueThisWeek, 0) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="rounded-lg bg-gray-50 p-4">
                <h4 class="text-sm font-medium text-gray-500 mb-2">This Month</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Jobs</p>
                        <p class="text-xl font-bold text-gray-800">{{ $jobsThisMonth }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Revenue</p>
                        <p class="text-xl font-bold text-gray-800">LKR {{ number_format($revenueThisMonth, 0) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="rounded-lg bg-gray-50 p-4">
                <h4 class="text-sm font-medium text-gray-500 mb-2">This Year</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Jobs</p>
                        <p class="text-xl font-bold text-gray-800">{{ $jobsThisYear }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Revenue</p>
                        <p class="text-xl font-bold text-gray-800">LKR {{ number_format($revenueThisYear, 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Monthly Reports -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Monthly Performance (Last 6 Months)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jobs</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($last6Months as $month)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $month['month'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $month['jobs'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">LKR {{ number_format($month['revenue'], 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Technician Stats -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Technician Performance</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jobs</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($technicianStats as $tech)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $tech->assignedUser ? $tech->assignedUser->name : 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tech->total_jobs }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">LKR {{ number_format($tech->total_revenue, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Jobs -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Recent Jobs</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job #</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($recentJobs as $job)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                            <a href="{{ route('jobs.show', $job) }}">{{ $job->job_number }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $job->customer->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $job->device_type }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
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
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$job->status] }}">
                                {{ $statusLabels[$job->status] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            LKR {{ number_format($job->cost, 0) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $job->assignedUser ? $job->assignedUser->name : 'Unassigned' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 