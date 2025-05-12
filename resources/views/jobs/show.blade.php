@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Job Details</h1>
            <p class="text-gray-600 mt-1">View service job information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('jobs.edit', $job) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit Job
            </a>
            <a href="{{ route('jobs.receipt', $job) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Receipt
            </a>
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Jobs
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Job Information -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Job Information</h3>
                <div class="flex items-center">
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
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColors[$job->status] }}">
                        {{ $statusLabels[$job->status] }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Job Number</h4>
                        <p class="mt-1 text-lg font-medium text-blue-600">{{ $job->job_number }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Received Date</h4>
                        <p class="mt-1 text-lg text-gray-800">{{ $job->received_date->format('Y-m-d') }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Device Type</h4>
                        <p class="mt-1 text-lg text-gray-800">{{ $job->device_type }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Brand / Model</h4>
                        <p class="mt-1 text-lg text-gray-800">{{ $job->brand ?: 'N/A' }} {{ $job->model ? '/ ' . $job->model : '' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Serial Number</h4>
                        <p class="mt-1 text-lg text-gray-800">{{ $job->serial_number ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Estimated Completion</h4>
                        <p class="mt-1 text-lg text-gray-800">{{ $job->estimated_completion_date ? $job->estimated_completion_date->format('Y-m-d') : 'Not set' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Issue Description</h4>
                        <p class="mt-1 text-base text-gray-800">{{ $job->issue_description }}</p>
                    </div>
                    @if($job->diagnosis)
                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Diagnosis</h4>
                        <p class="mt-1 text-base text-gray-800">{{ $job->diagnosis }}</p>
                    </div>
                    @endif
                    @if($job->resolution)
                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Resolution</h4>
                        <p class="mt-1 text-base text-gray-800">{{ $job->resolution }}</p>
                    </div>
                    @endif
                    @if($job->notes)
                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Additional Notes</h4>
                        <p class="mt-1 text-base text-gray-800">{{ $job->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Job Timeline</h3>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                @if(count($job->statusHistory) > 0 || $job->status != 'pending')
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Job received</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ $job->received_date->format('Y-m-d') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        @foreach($job->statusHistory as $history)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        @php
                                            $iconColor = 'bg-blue-500';
                                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />';
                                            
                                            if ($history->status == 'completed') {
                                                $iconColor = 'bg-green-500';
                                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
                                            } elseif ($history->status == 'delivered') {
                                                $iconColor = 'bg-indigo-500';
                                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />';
                                            } elseif ($history->status == 'waiting_for_parts') {
                                                $iconColor = 'bg-purple-500';
                                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />';
                                            } elseif ($history->status == 'cancelled') {
                                                $iconColor = 'bg-red-500';
                                                $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                                            }
                                        @endphp
                                        <span class="h-8 w-8 rounded-full {{ $iconColor }} flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                {!! $iconSvg !!}
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Status changed to <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $history->status)) }}</span>
                                                @if($history->notes)
                                                <span class="block mt-1 text-xs text-gray-500">{{ $history->notes }}</span>
                                                @endif
                                            </p>
                                            @if($history->user)
                                            <p class="text-xs text-gray-400 mt-1">by {{ $history->user->name }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ $history->created_at->format('Y-m-d h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Customer Information and Details -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Customer</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-lg">
                        {{ substr($job->customer->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">{{ $job->customer->name }}</h4>
                        <a href="{{ route('customers.show', $job->customer) }}" class="text-sm text-blue-600 hover:text-blue-900">View profile</a>
                    </div>
                </div>
                
                <div class="mt-6 space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                        @if($job->customer->email)
                            <a href="mailto:{{ $job->customer->email }}" class="mt-1 flex items-center text-sm text-blue-600 hover:text-blue-900">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $job->customer->email }}
                            </a>
                        @else
                            <p class="mt-1 text-sm text-gray-500">N/A</p>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                        @if($job->customer->phone)
                            <a href="tel:{{ $job->customer->phone }}" class="mt-1 flex items-center text-sm text-blue-600 hover:text-blue-900">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $job->customer->phone }}
                            </a>
                        @else
                            <p class="mt-1 text-sm text-gray-500">N/A</p>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Address</h4>
                        <p class="mt-1 text-sm text-gray-800">{{ $job->customer->address ?: 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Job Details</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Assigned To</h4>
                        <p class="mt-1 text-sm text-gray-800">{{ $job->assignedUser ? $job->assignedUser->name : 'Not assigned' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Estimated Cost</h4>
                        <p class="mt-1 text-lg font-bold text-gray-800">LKR {{ number_format($job->cost, 2) }}</p>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between">
                            <h4 class="text-sm font-medium text-gray-500">Status</h4>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$job->status] }}">
                                {{ $statusLabels[$job->status] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 