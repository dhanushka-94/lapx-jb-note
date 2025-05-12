@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Customer Details</h1>
            <p class="text-gray-600 mt-1">View customer information and their jobs</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit Customer
            </a>
            <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Customers
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Customer Information</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-sm font-medium text-gray-500">Name</h4>
                <p class="mt-1 text-lg text-gray-800">{{ $customer->name }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">Email</h4>
                <p class="mt-1 text-lg text-gray-800">{{ $customer->email ?: 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">Phone Number 1</h4>
                <p class="mt-1 text-lg text-gray-800">{{ $customer->formatted_phone_number_1 }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">Phone Number 2</h4>
                <p class="mt-1 text-lg text-gray-800">{{ $customer->formatted_phone_number_2 ?: 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">Home Phone</h4>
                <p class="mt-1 text-lg text-gray-800">{{ $customer->formatted_home_phone_number ?: 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">WhatsApp Number</h4>
                <p class="mt-1 text-lg text-gray-800">{{ $customer->formatted_whatsapp_number ?: 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">Address</h4>
                <p class="mt-1 text-lg text-gray-800">{{ $customer->address ?: 'N/A' }}</p>
            </div>
            <div class="md:col-span-2">
                <h4 class="text-sm font-medium text-gray-500">Notes</h4>
                <p class="mt-1 text-lg text-gray-800">{{ $customer->notes ?: 'No notes available' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500">SMS Notifications</h4>
                <p class="mt-1 text-lg">
                    @if($customer->disable_sms)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Disabled
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Enabled
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Job History</h3>
        <a href="{{ route('jobs.create', ['customer_id' => $customer->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New Job
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job #</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimated Cost</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($customer->jobs as $job)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">{{ $job->job_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $job->device_type }}</td>
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">LKR {{ number_format($job->cost, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $job->received_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:text-blue-900">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No jobs found for this customer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 