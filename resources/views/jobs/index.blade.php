@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Jobs</h1>
        <p class="text-gray-600 mt-1">Manage service jobs</p>
    </div>
    <a href="{{ route('jobs.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add New Job
    </a>
</div>

<!-- Filters -->
<div class="bg-white p-4 rounded-lg shadow-md mb-6">
    <form action="{{ route('jobs.index') }}" method="GET" id="jobs-filter-form">
        <!-- Search Bar -->
        <div class="mb-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search jobs by number, customer, device..." class="form-input pl-10 pr-4 py-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                @if(request('search'))
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <a href="{{ route('jobs.index', array_merge(request()->except('search'), ['page' => 1])) }}" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-full">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                    @foreach($statuses as $key => $value)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Assigned To Filter -->
            <div>
                <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">Technician</label>
                <select name="assigned_to" id="assigned_to" class="form-select rounded-md shadow-sm mt-1 block w-full">
                    <option value="all" {{ request('assigned_to') == 'all' ? 'selected' : '' }}>All Technicians</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Customer Filter -->
            <div>
                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                <select name="customer_id" id="customer_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                    <option value="all" {{ request('customer_id') == 'all' ? 'selected' : '' }}>All Customers</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Date Range Filters Toggle -->
            <div>
                <label for="show_date_filters" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <button type="button" id="show_date_filters" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full justify-center">
                    {{ request('received_date_from') || request('received_date_to') ? 'Date Range Applied' : 'Add Date Range' }}
                    <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Date Range Filters (Initially Hidden) -->
        <div id="date_range_filters" class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 {{ request('received_date_from') || request('received_date_to') ? '' : 'hidden' }}">
            <div>
                <label for="received_date_from" class="block text-sm font-medium text-gray-700 mb-1">Received Date From</label>
                <input type="date" name="received_date_from" id="received_date_from" value="{{ request('received_date_from') }}" class="form-input rounded-md shadow-sm mt-1 block w-full">
            </div>
            <div>
                <label for="received_date_to" class="block text-sm font-medium text-gray-700 mb-1">Received Date To</label>
                <input type="date" name="received_date_to" id="received_date_to" value="{{ request('received_date_to') }}" class="form-input rounded-md shadow-sm mt-1 block w-full">
            </div>
        </div>
        
        <!-- Filter Actions -->
        <div class="mt-4 flex justify-end space-x-3">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Reset Filters
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Status Update Modal -->
<div id="status-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Update Job Status
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            You are updating job <span id="modal-job-number" class="font-semibold"></span>.
                            Current status: <span id="modal-current-status" class="font-semibold"></span>
                        </p>
                        <div class="mt-4">
                            <label for="status-select" class="block text-sm font-medium text-gray-700">New Status</label>
                            <select id="status-select" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="waiting_for_parts">Waiting for Parts</option>
                                <option value="completed">Completed</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="button" id="update-status-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                Update Status
            </button>
            <button type="button" id="cancel-status-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job #</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($jobs as $job)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">{{ $job->job_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold">
                                    {{ substr($job->customer->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $job->customer->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $job->customer->formatted_phone_number_1 }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ $job->device_type }}</div>
                            <div class="text-xs text-gray-400">{{ $job->brand }} {{ $job->model }}</div>
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
                            <span id="status-badge-{{ $job->id }}" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$job->status] }}">
                                {{ $statusLabels[$job->status] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($job->received_date)->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $job->assignedUser ? $job->assignedUser->name : 'Unassigned' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <button type="button" 
                                    class="text-green-600 hover:text-green-900 inline-flex items-center status-change-button"
                                    data-job-id="{{ $job->id }}"
                                    data-job-number="{{ $job->job_number }}"
                                    data-current-status="{{ $job->status }}">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Change Status
                                </button>
                                <a href="{{ route('jobs.receipt', $job) }}" target="_blank" class="text-purple-600 hover:text-purple-900 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Print
                                </a>
                                <a href="{{ route('jobs.edit', $job) }}" class="text-yellow-600 hover:text-yellow-900 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="inline-flex items-center" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 inline-flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No jobs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $jobs->appends(request()->query())->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug logging to check if event listeners are being attached
    console.log('DOM loaded, initializing event handlers');
    
    // Search and filter functionality
    const showDateFiltersBtn = document.getElementById('show_date_filters');
    const dateRangeFilters = document.getElementById('date_range_filters');
    
    // Toggle date range filters visibility
    showDateFiltersBtn.addEventListener('click', function() {
        dateRangeFilters.classList.toggle('hidden');
    });
    
    // Auto-submit on select change
    const autoSubmitSelects = document.querySelectorAll('#status, #assigned_to, #customer_id');
    autoSubmitSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('jobs-filter-form').submit();
        });
    });
    
    // Status change modal functionality
    const statusModal = document.getElementById('status-modal');
    const statusButtons = document.querySelectorAll('.status-change-button');
    const modalJobNumber = document.getElementById('modal-job-number');
    const modalCurrentStatus = document.getElementById('modal-current-status');
    const statusSelect = document.getElementById('status-select');
    const updateStatusBtn = document.getElementById('update-status-btn');
    const cancelStatusBtn = document.getElementById('cancel-status-btn');
    
    let currentJobId = null;
    
    console.log('Found status buttons:', statusButtons.length);
    
    // Open modal when status change button is clicked
    statusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Status button clicked');
            
            const jobId = this.getAttribute('data-job-id');
            const jobNumber = this.getAttribute('data-job-number');
            const currentStatus = this.getAttribute('data-current-status');
            
            console.log('Job details:', jobId, jobNumber, currentStatus);
            
            currentJobId = jobId;
            modalJobNumber.textContent = jobNumber;
            modalCurrentStatus.textContent = formatStatus(currentStatus);
            statusSelect.value = currentStatus;
            
            statusModal.classList.remove('hidden');
        });
    });
    
    // Close modal when cancel button is clicked
    cancelStatusBtn.addEventListener('click', function() {
        statusModal.classList.add('hidden');
    });
    
    // Also close modal when clicking outside (on the overlay)
    statusModal.addEventListener('click', function(e) {
        if (e.target === statusModal) {
            statusModal.classList.add('hidden');
        }
    });
    
    // Update status when update button is clicked
    updateStatusBtn.addEventListener('click', function() {
        if (!currentJobId) return;
        
        const newStatus = statusSelect.value;
        console.log('Updating status to:', newStatus);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Send update request using URLSearchParams instead of FormData
        fetch(`/jobs/${currentJobId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken
            },
            body: new URLSearchParams({
                'status': newStatus,
                '_token': csrfToken
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);
            
            if (data.success) {
                // Update the UI
                const statusBadge = document.getElementById(`status-badge-${currentJobId}`);
                if (statusBadge) {
                    const statusColors = {
                        'pending': 'bg-yellow-100 text-yellow-800',
                        'in_progress': 'bg-blue-100 text-blue-800',
                        'waiting_for_parts': 'bg-purple-100 text-purple-800',
                        'completed': 'bg-green-100 text-green-800',
                        'delivered': 'bg-indigo-100 text-indigo-800',
                        'cancelled': 'bg-red-100 text-red-800',
                    };
                    
                    // Remove old status classes and add new ones
                    statusBadge.className = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full';
                    // Split the classes string and add each class individually
                    const classesToAdd = statusColors[newStatus].split(' ');
                    classesToAdd.forEach(cls => {
                        statusBadge.classList.add(cls);
                    });
                    statusBadge.textContent = formatStatus(newStatus);
                    
                    // Update button data attribute
                    const statusButton = document.querySelector(`.status-change-button[data-job-id="${currentJobId}"]`);
                    if (statusButton) {
                        statusButton.setAttribute('data-current-status', newStatus);
                    }
                    
                    // Close modal and show success notification
                    statusModal.classList.add('hidden');
                    alert('Status updated successfully!');
                    
                    // Refresh the page to show updated data
                    window.location.reload();
                }
            } else {
                alert('Failed to update status. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the status.');
        });
    });
    
    // Format status for display
    function formatStatus(status) {
        const statusLabels = {
            'pending': 'Pending',
            'in_progress': 'In Progress',
            'waiting_for_parts': 'Waiting for Parts',
            'completed': 'Completed',
            'delivered': 'Delivered',
            'cancelled': 'Cancelled',
        };
        
        return statusLabels[status] || status;
    }
});
</script>
@endsection 