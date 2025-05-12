@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Technician Details</h1>
    <div class="flex space-x-2">
        <a href="{{ route('technicians.edit', $technician) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-edit mr-1"></i> Edit
        </a>
        <a href="{{ route('technicians.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Technician Information Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden md:col-span-1">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 px-6 py-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-16 w-16 rounded-full bg-white flex items-center justify-center text-indigo-700 font-bold text-2xl">
                    {{ substr($technician->name, 0, 1) }}
                </div>
                <div class="ml-4 text-white">
                    <h3 class="text-lg font-semibold">{{ $technician->name }}</h3>
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $technician->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $technician->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <h4 class="text-sm font-medium text-gray-500">Contact Information</h4>
                <div class="mt-2">
                    <p class="text-gray-700 mb-1"><i class="fas fa-envelope mr-2 text-gray-500"></i> {{ $technician->email }}</p>
                    @if($technician->phone_number)
                        <p class="text-gray-700"><i class="fas fa-phone mr-2 text-gray-500"></i> {{ $technician->phone_number }}</p>
                    @endif
                </div>
            </div>
            
            <div class="mb-4">
                <h4 class="text-sm font-medium text-gray-500">Skills & Expertise</h4>
                <div class="mt-2">
                    @if($technician->skills)
                        <p class="text-gray-700">{{ $technician->skills }}</p>
                    @else
                        <p class="text-gray-500 italic">No skills listed</p>
                    @endif
                </div>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-500">Account Information</h4>
                <div class="mt-2">
                    <p class="text-gray-700 mb-1"><i class="fas fa-calendar mr-2 text-gray-500"></i> Created: {{ $technician->created_at->format('M d, Y') }}</p>
                    <p class="text-gray-700"><i class="fas fa-clock mr-2 text-gray-500"></i> Last Updated: {{ $technician->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Jobs and Summary Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden md:col-span-2">
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-white">Assigned Jobs</h3>
            <div class="flex space-x-2 items-center">
                <span class="bg-white text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full">
                    {{ $activeJobsCount }} Active Jobs
                </span>
                <a href="{{ route('technicians.jobs', $technician) }}" class="bg-white text-blue-800 hover:bg-blue-100 text-xs font-semibold px-2.5 py-1 rounded-full inline-flex items-center">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        <div class="p-6">
            @if($assignedJobs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($assignedJobs as $job)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $job->job_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $job->customer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $job->device_type }} {{ $job->brand }} {{ $job->model }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($job->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($job->status == 'in_progress') bg-blue-100 text-blue-800
                                            @elseif($job->status == 'waiting_for_parts') bg-purple-100 text-purple-800
                                            @elseif($job->status == 'completed') bg-green-100 text-green-800
                                            @elseif($job->status == 'delivered') bg-teal-100 text-teal-800
                                            @elseif($job->status == 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-6">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No jobs assigned</h3>
                    <p class="mt-1 text-sm text-gray-500">This technician doesn't have any jobs assigned yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection