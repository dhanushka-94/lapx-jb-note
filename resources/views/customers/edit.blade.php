@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-user-edit mr-2"></i>Edit Customer</h1>
            <p class="text-gray-600 mt-1">Update customer information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('customers.show', $customer) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 btn-effect">
                <i class="fas fa-eye mr-2"></i>
                View Customer
            </a>
            <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 btn-effect">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Customers
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800"><i class="fas fa-info-circle mr-2"></i>Customer Information</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user text-gray-400 mr-1"></i>Name <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('name') border-red-500 @enderror" placeholder="Customer full name" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-envelope text-gray-400 mr-1"></i>Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('email') border-red-500 @enderror" placeholder="customer@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Phone Number 1 Field -->
                <div>
                    <label for="phone_number_1" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-mobile-alt text-gray-400 mr-1"></i>Phone Number 1 <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="phone_number_1" id="phone_number_1" value="{{ old('phone_number_1', $customer->phone_number_1) }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('phone_number_1') border-red-500 @enderror" placeholder="Primary mobile number" required>
                    @error('phone_number_1')
                        <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Phone Number 2 Field -->
                <div>
                    <label for="phone_number_2" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-mobile text-gray-400 mr-1"></i>Phone Number 2
                    </label>
                    <input type="text" name="phone_number_2" id="phone_number_2" value="{{ old('phone_number_2', $customer->phone_number_2) }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('phone_number_2') border-red-500 @enderror" placeholder="Secondary mobile number">
                    @error('phone_number_2')
                        <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Home Phone Field -->
                <div>
                    <label for="home_phone_number" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-phone text-gray-400 mr-1"></i>Home Phone Number
                    </label>
                    <input type="text" name="home_phone_number" id="home_phone_number" value="{{ old('home_phone_number', $customer->home_phone_number) }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('home_phone_number') border-red-500 @enderror" placeholder="Landline number">
                    @error('home_phone_number')
                        <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- WhatsApp Number Field -->
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-whatsapp text-gray-400 mr-1"></i>WhatsApp Number
                    </label>
                    <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $customer->whatsapp_number) }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('whatsapp_number') border-red-500 @enderror" placeholder="WhatsApp contact number">
                    @error('whatsapp_number')
                        <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Address Field (Full Width) -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>Address
                    </label>
                    <textarea name="address" id="address" rows="3" class="form-textarea rounded-md shadow-sm mt-1 block w-full @error('address') border-red-500 @enderror" placeholder="Customer's full address">{{ old('address', $customer->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Notes Field (Full Width) -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-sticky-note text-gray-400 mr-1"></i>Notes
                    </label>
                    <textarea name="notes" id="notes" rows="3" class="form-textarea rounded-md shadow-sm mt-1 block w-full @error('notes') border-red-500 @enderror" placeholder="Additional notes about the customer">{{ old('notes', $customer->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Disable SMS Field -->
                <div class="md:col-span-2">
                    <div class="flex items-center mt-2">
                        <input type="checkbox" name="disable_sms" id="disable_sms" value="1" {{ old('disable_sms', $customer->disable_sms) ? 'checked' : '' }} class="rounded text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <label for="disable_sms" class="ml-2 block text-sm text-gray-700">
                            <i class="fas fa-sms text-gray-400 mr-1"></i>Disable SMS notifications for this customer
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 ml-6">Check this box if the customer has requested not to receive SMS notifications about service jobs.</p>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200 btn-effect">
                        <i class="fas fa-save mr-2"></i>
                        Update Customer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 