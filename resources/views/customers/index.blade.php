@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-users mr-2"></i>Customers</h1>
        <p class="text-gray-600 mt-1">Manage customer accounts</p>
    </div>
    <a href="{{ route('customers.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 btn-effect">
        <i class="fas fa-user-plus mr-2"></i>
        Add New Customer
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jobs</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><i class="fas fa-hashtag text-xs text-gray-400 mr-1"></i>{{ $customer->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold shadow-sm">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($customer->email)
                                <span class="flex items-center"><i class="fas fa-envelope text-gray-400 mr-1"></i>{{ $customer->email }}</span>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="flex items-center"><i class="fas fa-mobile-alt text-gray-400 mr-1"></i>{{ $customer->phone_number_1 }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-clipboard-list mr-1"></i>{{ $customer->jobs->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    View
                                </a>
                                <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-600 hover:text-yellow-900 inline-flex items-center">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-flex items-center" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 inline-flex items-center">
                                        <i class="fas fa-trash-alt mr-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>No customers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $customers->links() }}
    </div>
</div>
@endsection 