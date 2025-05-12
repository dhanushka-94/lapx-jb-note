@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-users mr-2"></i>Customers</h1>
        <p class="text-gray-600 mt-1">Manage customer accounts</p>
    </div>
    <a href="{{ route('customers.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-[#0a2463] border border-transparent rounded-md font-medium text-sm text-white hover:bg-[#1e40af] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 btn-effect">
        <i class="fas fa-user-plus mr-2"></i>
        Add New Customer
    </a>
</div>

<!-- Search Form -->
<div class="mb-6 bg-white rounded-lg shadow-sm p-4">
    <form action="{{ route('customers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name, email, phone, or address..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-[#0a2463] focus:border-[#0a2463] sm:text-sm"
            >
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#0a2463] hover:bg-[#1e40af] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-search mr-2"></i>
                Search
            </button>
            @if(request()->has('search') && request('search') != '')
                <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-times mr-2"></i>
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Primary Phone</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Other Contacts</th>
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
                            <span class="flex items-center">
                                <i class="fas fa-mobile-alt text-gray-400 mr-1"></i>
                                {{ $customer->formatted_phone_number_1 ?? $customer->phone_number_1 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($customer->phone_number_2 || $customer->home_phone_number || $customer->whatsapp_number)
                                <div class="flex flex-col space-y-1">
                                    @if($customer->phone_number_2)
                                        <span class="flex items-center text-xs">
                                            <i class="fas fa-mobile text-gray-400 mr-1"></i> {{ $customer->formatted_phone_number_2 }}
                                        </span>
                                    @endif
                                    @if($customer->home_phone_number)
                                        <span class="flex items-center text-xs">
                                            <i class="fas fa-phone text-gray-400 mr-1"></i> {{ $customer->formatted_home_phone_number }}
                                        </span>
                                    @endif
                                    @if($customer->whatsapp_number)
                                        <span class="flex items-center text-xs">
                                            <i class="fab fa-whatsapp text-green-500 mr-1"></i> {{ $customer->formatted_whatsapp_number }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
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
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            @if(request()->has('search') && request('search') != '')
                                <i class="fas fa-search mr-1"></i>No customers found matching "{{ request('search') }}".
                            @else
                                <i class="fas fa-info-circle mr-1"></i>No customers found.
                            @endif
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