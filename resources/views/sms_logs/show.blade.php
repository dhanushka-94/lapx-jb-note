@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">SMS Log Details</h1>
            <p class="text-gray-600 mt-1">View SMS notification details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('sms-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to SMS Logs
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">SMS Information</h3>
            <div class="flex items-center">
                @if($smsLog->success)
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Success
                    </span>
                @else
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Failed
                    </span>
                @endif
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Date & Time</h4>
                    <p class="mt-1 text-lg text-gray-800">{{ $smsLog->created_at->format('Y-m-d h:i A') }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Type</h4>
                    <p class="mt-1 text-lg text-gray-800">
                        @if($smsLog->type == 'job_created')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Job Created
                            </span>
                        @elseif($smsLog->type == 'status_update')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                Status Update
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $smsLog->type }}
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Phone Number</h4>
                    <p class="mt-1 text-lg text-gray-800">{{ $smsLog->phone_number }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Customer</h4>
                    @if($smsLog->customer)
                        <div class="flex items-center mt-1">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold">
                                {{ substr($smsLog->customer->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-900">{{ $smsLog->customer->name }}</div>
                                <div class="text-sm text-gray-500">{{ $smsLog->customer->phone }}</div>
                            </div>
                        </div>
                    @else
                        <p class="mt-1 text-lg text-gray-800">Unknown</p>
                    @endif
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Job</h4>
                    @if($smsLog->job)
                        <a href="{{ route('jobs.show', $smsLog->job) }}" class="mt-1 flex items-center text-blue-600 hover:text-blue-900">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ $smsLog->job->job_number }}
                        </a>
                    @else
                        <p class="mt-1 text-lg text-gray-800">N/A</p>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500">Message</h4>
                    <p class="mt-1 p-4 bg-gray-50 rounded text-base text-gray-800 break-words">{{ $smsLog->message }}</p>
                </div>
                @if($smsLog->response)
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500">API Response</h4>
                    <pre class="mt-1 p-4 bg-gray-50 rounded text-sm text-gray-800 overflow-auto max-h-48">{{ $smsLog->response }}</pre>
                </div>
                @endif
                @if($smsLog->error)
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500">Error</h4>
                    <pre class="mt-1 p-4 bg-red-50 rounded text-sm text-red-800 break-words">{{ $smsLog->error }}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 