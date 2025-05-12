@extends('layouts.app')

@section('content')
<div class="py-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Users Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Users</h2>
                <span class="flex items-center justify-center bg-blue-100 h-10 w-10 rounded-full shadow-sm">
                    <i class="fas fa-user-cog text-lg text-[#0a2463]"></i>
                </span>
            </div>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="text-3xl font-bold text-gray-800">{{ $userCount }}</p>
                    <p class="text-sm text-gray-500">Total Users</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('users.index') }}" class="block text-center bg-[#0a2463] hover:bg-[#1e40af] text-white font-medium py-2 px-4 rounded transition-all duration-200 btn-effect">
                    <i class="fas fa-eye mr-1"></i> View All Users
                </a>
            </div>
        </div>
        
        <!-- Customers Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Customers</h2>
                <span class="flex items-center justify-center bg-blue-100 h-10 w-10 rounded-full shadow-sm">
                    <i class="fas fa-users text-lg text-[#0a2463]"></i>
                </span>
            </div>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="text-3xl font-bold text-gray-800">{{ $customerCount }}</p>
                    <p class="text-sm text-gray-500">Total Customers</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('customers.index') }}" class="block text-center bg-[#0a2463] hover:bg-[#1e40af] text-white font-medium py-2 px-4 rounded transition-all duration-200 btn-effect">
                    <i class="fas fa-eye mr-1"></i> View All Customers
                </a>
            </div>
        </div>
        
        <!-- Jobs Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Service Jobs</h2>
                <span class="flex items-center justify-center bg-blue-100 h-10 w-10 rounded-full shadow-sm">
                    <i class="fas fa-clipboard-list text-lg text-[#0a2463]"></i>
                </span>
            </div>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="text-3xl font-bold text-gray-800">{{ $jobCount }}</p>
                    <p class="text-sm text-gray-500">Total Jobs</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('jobs.index') }}" class="block text-center bg-[#0a2463] hover:bg-[#1e40af] text-white font-medium py-2 px-4 rounded transition-all duration-200 btn-effect">
                    <i class="fas fa-eye mr-1"></i> View All Jobs
                </a>
            </div>
        </div>
    </div>
    
    <!-- Reports Quick Access Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 mb-8">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-chart-bar mr-2"></i>Service Center Reports
                </h3>
                <a href="{{ route('reports.index') }}" class="inline-flex items-center px-3 py-1 border border-white text-sm leading-5 font-medium rounded-md text-white hover:bg-white hover:text-blue-600 focus:outline-none transition duration-150 ease-in-out">
                    View Reports <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">Access comprehensive reports and analytics about your service center's performance, including job statistics, revenue metrics, and technician productivity.</p>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-500 mr-3">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Job Status</p>
                            <p class="text-lg font-semibold text-gray-800">Overview</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center text-green-500 mr-3">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Revenue</p>
                            <p class="text-lg font-semibold text-gray-800">Analysis</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-500 mr-3">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Technician</p>
                            <p class="text-lg font-semibold text-gray-800">Performance</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-500 mr-3">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Monthly</p>
                            <p class="text-lg font-semibold text-gray-800">Trends</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Daily Highlights - Jobs Requiring Attention -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 mb-8">
        <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-yellow-500 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-bell mr-2"></i>Daily Highlights - Jobs Requiring Attention
                </h3>
                <a href="{{ route('jobs.highlights') }}" class="inline-flex items-center px-3 py-1 border border-white text-sm leading-5 font-medium rounded-md text-white hover:bg-white hover:text-red-600 focus:outline-none transition duration-150 ease-in-out">
                    View All Highlights <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Pending Jobs Card -->
                <div class="rounded-lg bg-yellow-50 border border-yellow-100 p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-base font-semibold text-yellow-800">
                            <i class="fas fa-clock mr-2"></i>Pending
                        </h4>
                        <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-800 font-bold">
                            {{ $pendingCount }}
                        </div>
                    </div>
                    <div class="divide-y divide-yellow-100">
                        @forelse($pendingJobs as $job)
                            <div class="py-2 hover:bg-yellow-100 rounded transition-colors px-2">
                                <a href="{{ route('jobs.show', $job) }}" class="text-sm font-medium text-yellow-800 hover:text-yellow-900 block">
                                    {{ $job->job_number }}
                                </a>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-yellow-700">{{ $job->customer->name }}</span>
                                    <span class="text-xs text-yellow-700">{{ $job->device_type }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-yellow-700 py-2">No pending jobs</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- In Progress Jobs Card -->
                <div class="rounded-lg bg-blue-50 border border-blue-100 p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-base font-semibold text-blue-800">
                            <i class="fas fa-tools mr-2"></i>In Progress
                        </h4>
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-bold">
                            {{ $inProgressCount }}
                        </div>
                    </div>
                    <div class="divide-y divide-blue-100">
                        @forelse($inProgressJobs as $job)
                            <div class="py-2 hover:bg-blue-100 rounded transition-colors px-2">
                                <a href="{{ route('jobs.show', $job) }}" class="text-sm font-medium text-blue-800 hover:text-blue-900 block">
                                    {{ $job->job_number }}
                                </a>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-blue-700">{{ $job->customer->name }}</span>
                                    <span class="text-xs text-blue-700">{{ $job->device_type }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-blue-700 py-2">No jobs in progress</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Waiting for Parts Jobs Card -->
                <div class="rounded-lg bg-purple-50 border border-purple-100 p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-base font-semibold text-purple-800">
                            <i class="fas fa-truck-loading mr-2"></i>Waiting for Parts
                        </h4>
                        <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-800 font-bold">
                            {{ $waitingForPartsCount }}
                        </div>
                    </div>
                    <div class="divide-y divide-purple-100">
                        @forelse($waitingForPartsJobs as $job)
                            <div class="py-2 hover:bg-purple-100 rounded transition-colors px-2">
                                <a href="{{ route('jobs.show', $job) }}" class="text-sm font-medium text-purple-800 hover:text-purple-900 block">
                                    {{ $job->job_number }}
                                </a>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-purple-700">{{ $job->customer->name }}</span>
                                    <span class="text-xs text-purple-700">{{ $job->device_type }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-purple-700 py-2">No jobs waiting for parts</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-3">
                <div class="text-sm bg-gray-100 px-3 py-1 rounded-full">
                    <span class="text-gray-600">Total jobs requiring attention: {{ $pendingCount + $inProgressCount + $waitingForPartsCount }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Jobs -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-clipboard-list mr-2 text-[#0a2463]"></i>Recent Jobs
                    </h3>
                    <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-[#0a2463] hover:bg-[#1e40af] focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition duration-150 ease-in-out">
                        <i class="fas fa-plus mr-1"></i> New Job
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentJobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentJobs as $job)
                            <div class="border border-gray-200 rounded-md p-4 hover:bg-gray-50 transition-all duration-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $job->title ?? 'Job #' . $job->id }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="fas fa-user-circle mr-1 text-gray-400"></i>{{ $job->customer->name ?? 'Unknown Customer' }}
                                        </p>
                                        <div class="flex items-center mt-2">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($job->status == 'pending') bg-yellow-100 text-yellow-800 
                                                @elseif($job->status == 'in_progress') bg-blue-100 text-blue-800 
                                                @elseif($job->status == 'completed') bg-green-100 text-green-800 
                                                @elseif($job->status == 'cancelled') bg-red-100 text-red-800 
                                                @else bg-gray-100 text-gray-800 @endif">
                                                <i class="fas fa-circle text-xs mr-1"></i>
                                                @if($job->status == 'pending') Pending
                                                @elseif($job->status == 'in_progress') In Progress
                                                @elseif($job->status == 'completed') Completed
                                                @elseif($job->status == 'cancelled') Cancelled
                                                @else {{ $job->status }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">
                                            <i class="far fa-calendar-alt mr-1"></i>{{ $job->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-[#0a2463] hover:text-[#1e40af] inline-flex items-center">
                            View all jobs <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500">No jobs found</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Recent Customers -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-users mr-2 text-[#0a2463]"></i>Recent Customers
                    </h3>
                    <a href="{{ route('customers.create') }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-[#0a2463] hover:bg-[#1e40af] focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition duration-150 ease-in-out">
                        <i class="fas fa-plus mr-1"></i> New Customer
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentCustomers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentCustomers as $customer)
                            <div class="flex items-center space-x-4 p-2 hover:bg-gray-50 rounded-md transition-all duration-200">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-[#0a2463] font-semibold shadow-sm">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $customer->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        <i class="fas fa-mobile-alt mr-1 text-xs"></i>{{ $customer->formatted_phone_number_1 ?? $customer->phone_number_1 }}
                                    </p>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-[#0a2463]">
                                        <i class="fas fa-clipboard-list mr-1"></i>{{ $customer->jobs->count() }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('customers.index') }}" class="text-sm font-medium text-[#0a2463] hover:text-[#1e40af] inline-flex items-center">
                            View all customers <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500">No customers found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 