@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">User Details</h2>
        <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            Back to Users
        </a>
    </div>

    <div class="mb-6">
        <div class="border-b pb-3 mb-3">
            <p class="text-sm text-gray-600">ID</p>
            <p class="text-gray-900 font-medium">{{ $user->id }}</p>
        </div>
        
        <div class="border-b pb-3 mb-3">
            <p class="text-sm text-gray-600">Name</p>
            <p class="text-gray-900 font-medium">{{ $user->name }}</p>
        </div>
        
        <div class="border-b pb-3 mb-3">
            <p class="text-sm text-gray-600">Email</p>
            <p class="text-gray-900 font-medium">{{ $user->email }}</p>
        </div>
        
        <div class="border-b pb-3 mb-3">
            <p class="text-sm text-gray-600">Created At</p>
            <p class="text-gray-900 font-medium">{{ $user->created_at->format('F d, Y h:i A') }}</p>
        </div>
        
        <div>
            <p class="text-sm text-gray-600">Updated At</p>
            <p class="text-gray-900 font-medium">{{ $user->updated_at->format('F d, Y h:i A') }}</p>
        </div>
    </div>

    <div class="flex space-x-2">
        <a href="{{ route('users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Edit
        </a>
        
        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                Delete
            </button>
        </form>
    </div>
</div>
@endsection 