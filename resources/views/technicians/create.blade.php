@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Add New Technician</h2>
        <a href="{{ route('technicians.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            Back to Technicians
        </a>
    </div>

    <form method="POST" action="{{ route('technicians.store') }}" id="technicianForm">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
            <input id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input id="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
            <input id="password-confirm" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="mb-4">
            <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
            <input id="phone_number" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone_number') border-red-500 @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="tel">
            @error('phone_number')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="skills" class="block text-gray-700 text-sm font-bold mb-2">Skills & Expertise</label>
            <textarea id="skills" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('skills') border-red-500 @enderror" name="skills" rows="3">{{ old('skills') }}</textarea>
            <p class="text-gray-500 text-xs mt-1">List technician's skills, separated by commas (e.g., Laptop repair, Phone screen replacement, Motherboard diagnosis)</p>
            @error('skills')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <div class="flex items-center">
                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} checked>
                <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
            </div>
            <p class="text-gray-500 text-xs mt-1">Active technicians can be assigned to jobs</p>
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Create Technician
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('technicianForm');
    
    form.addEventListener('submit', function(e) {
        // Debug information
        console.log('Form is being submitted');
        
        // Log the form values
        const formData = new FormData(form);
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
        
        // Check if is_active checkbox is present in form data
        console.log('is_active in formData:', formData.has('is_active'));
        console.log('is_active checkbox checked state:', document.getElementById('is_active').checked);
        
        // Remove this line in production - it's only for debugging
        // e.preventDefault();
    });
});
</script>
@endsection 