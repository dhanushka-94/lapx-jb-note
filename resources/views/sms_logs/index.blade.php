@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">SMS Logs</h1>
        <p class="text-gray-600 mt-1">View all SMS notification logs</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-4 rounded-lg shadow-md mb-6">
    <form action="{{ route('sms-logs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
            <select name="status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-full" onchange="this.form.submit()">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                @foreach($statuses as $key => $value)
                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Filter by Type</label>
            <select name="type" id="type" class="form-select rounded-md shadow-sm mt-1 block w-full" onchange="this.form.submit()">
                <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                @foreach($types as $key => $value)
                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Customer</label>
            <select name="customer_id" id="customer_id" class="form-select rounded-md shadow-sm mt-1 block w-full" onchange="this.form.submit()">
                <option value="all" {{ request('customer_id') == 'all' ? 'selected' : '' }}>All Customers</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="form-input rounded-md shadow-sm mt-1 block w-full">
        </div>
        <div>
            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="form-input rounded-md shadow-sm mt-1 block w-full">
        </div>
        <div class="flex items-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Apply Filters
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job #</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($smsLogs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->created_at->format('Y-m-d h:i A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($log->customer)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold">
                                        {{ substr($log->customer->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $log->customer->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->customer->phone }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400">Unknown</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($log->job)
                                <a href="{{ route('jobs.show', $log->job) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $log->job->job_number }}
                                </a>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->phone_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($log->type == 'job_created')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Job Created
                                </span>
                            @elseif($log->type == 'status_update')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Status Update
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $log->type }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($log->success)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Success
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('sms-logs.show', $log) }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No SMS logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $smsLogs->appends(request()->query())->links() }}
    </div>
</div>
@endsection 