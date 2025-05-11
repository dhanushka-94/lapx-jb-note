@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Create New Job</h1>
            <p class="text-gray-600 mt-1">Add a new service job to the system</p>
        </div>
        <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Jobs
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Job Information</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Job Number -->
                <div>
                    <label for="job_number" class="block text-sm font-medium text-gray-700 mb-1">Job Number <span class="text-red-600">*</span></label>
                    <input type="text" name="job_number" id="job_number" value="{{ old('job_number', $jobNumber) }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('job_number') border-red-500 @enderror" placeholder="Job number" readonly>
                    @error('job_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Customer Selection -->
                <div class="md:col-span-2">
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer <span class="text-red-600">*</span></label>
                    <select name="customer_id" id="customer_id" class="form-select rounded-md shadow-sm mt-1 block w-full @error('customer_id') border-red-500 @enderror" required>
                        <option value="">Select a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ (old('customer_id') == $customer->id || request('customer_id') == $customer->id) ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-md mb-6">
                <h4 class="text-base font-medium text-gray-700 mb-3">Device Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Device Type -->
                    <div>
                        <label for="device_type" class="block text-sm font-medium text-gray-700 mb-1">Device Type <span class="text-red-600">*</span></label>
                        <select name="device_type" id="device_type" class="form-select rounded-md shadow-sm mt-1 block w-full @error('device_type') border-red-500 @enderror" required>
                            <option value="">Select device type</option>
                            <option value="Desktop Computer" {{ old('device_type') == 'Desktop Computer' ? 'selected' : '' }}>Desktop Computer</option>
                            <option value="Laptop" {{ old('device_type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="Tablet" {{ old('device_type') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Smartphone" {{ old('device_type') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                            <option value="Printer" {{ old('device_type') == 'Printer' ? 'selected' : '' }}>Printer</option>
                            <option value="Monitor" {{ old('device_type') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                            <option value="Other" {{ old('device_type') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('device_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('brand') border-red-500 @enderror" placeholder="e.g. Dell, HP, Apple">
                        @error('brand')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Model -->
                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" id="model" value="{{ old('model') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('model') border-red-500 @enderror" placeholder="e.g. XPS 15, MacBook Pro">
                        @error('model')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Serial Number -->
                    <div>
                        <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('serial_number') border-red-500 @enderror" placeholder="Device serial number">
                        @error('serial_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-600">*</span></label>
                    <select name="status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-full @error('status') border-red-500 @enderror" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="waiting_for_parts" {{ old('status') == 'waiting_for_parts' ? 'selected' : '' }}>Waiting for Parts</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Assigned To -->
                <div>
                    <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">Assign To</label>
                    <select name="assigned_to" id="assigned_to" class="form-select rounded-md shadow-sm mt-1 block w-full @error('assigned_to') border-red-500 @enderror">
                        <option value="">Not assigned</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Cost -->
                <div>
                    <label for="cost" class="block text-sm font-medium text-gray-700 mb-1">Cost ($)</label>
                    <input type="number" name="cost" id="cost" value="{{ old('cost', '0.00') }}" step="0.01" min="0" class="form-input rounded-md shadow-sm mt-1 block w-full @error('cost') border-red-500 @enderror" placeholder="0.00">
                    @error('cost')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Received Date -->
                <div>
                    <label for="received_date" class="block text-sm font-medium text-gray-700 mb-1">Received Date <span class="text-red-600">*</span></label>
                    <input type="date" name="received_date" id="received_date" value="{{ old('received_date', date('Y-m-d')) }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('received_date') border-red-500 @enderror" required>
                    @error('received_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Estimated Completion Date -->
                <div>
                    <label for="estimated_completion_date" class="block text-sm font-medium text-gray-700 mb-1">Estimated Completion</label>
                    <input type="date" name="estimated_completion_date" id="estimated_completion_date" value="{{ old('estimated_completion_date') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('estimated_completion_date') border-red-500 @enderror">
                    @error('estimated_completion_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Completed Date -->
                <div>
                    <label for="completed_date" class="block text-sm font-medium text-gray-700 mb-1">Completed Date</label>
                    <input type="date" name="completed_date" id="completed_date" value="{{ old('completed_date') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('completed_date') border-red-500 @enderror">
                    @error('completed_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Delivered Date -->
                <div>
                    <label for="delivered_date" class="block text-sm font-medium text-gray-700 mb-1">Delivered Date</label>
                    <input type="date" name="delivered_date" id="delivered_date" value="{{ old('delivered_date') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('delivered_date') border-red-500 @enderror">
                    @error('delivered_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-6 mb-6">
                <!-- Issue Description -->
                <div>
                    <label for="issue_description" class="block text-sm font-medium text-gray-700 mb-1">Issue Description <span class="text-red-600">*</span></label>
                    <textarea name="issue_description" id="issue_description" rows="3" class="form-textarea rounded-md shadow-sm mt-1 block w-full @error('issue_description') border-red-500 @enderror" placeholder="Describe the issue with the device" required>{{ old('issue_description') }}</textarea>
                    @error('issue_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Diagnosis -->
                <div>
                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" rows="3" class="form-textarea rounded-md shadow-sm mt-1 block w-full @error('diagnosis') border-red-500 @enderror" placeholder="Technical diagnosis of the issue">{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Resolution -->
                <div>
                    <label for="resolution" class="block text-sm font-medium text-gray-700 mb-1">Resolution</label>
                    <textarea name="resolution" id="resolution" rows="3" class="form-textarea rounded-md shadow-sm mt-1 block w-full @error('resolution') border-red-500 @enderror" placeholder="How the issue was resolved">{{ old('resolution') }}</textarea>
                    @error('resolution')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="form-textarea rounded-md shadow-sm mt-1 block w-full @error('notes') border-red-500 @enderror" placeholder="Any additional notes about this job">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Job
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 