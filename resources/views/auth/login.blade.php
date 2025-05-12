@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-blue-50 to-white">
    <div class="w-full sm:max-w-md mt-6 mb-8 text-center">
        <div class="flex flex-col items-center justify-center mb-4">
            <img src="{{ asset('logo-white.png') }}" alt="Logo" class="h-16 bg-[#0a2463] p-3 rounded-lg">
            <div class="mt-3 font-semibold text-center text-gray-700">
                <span>Laptop Expert (Pvt) Ltd</span><br>
                <span>Service Center</span>
            </div>
        </div>
        <p class="mt-2 text-gray-600">Sign in to your account</p>
    </div>

    <div class="w-full sm:max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" class="pl-10 focus:ring-[#0a2463] focus:border-[#0a2463] block w-full rounded-md py-2 px-3 border border-gray-300 shadow-sm @error('email') border-red-300 text-red-900 placeholder-red-300 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" class="pl-10 focus:ring-[#0a2463] focus:border-[#0a2463] block w-full rounded-md py-2 px-3 border border-gray-300 shadow-sm @error('password') border-red-300 text-red-900 placeholder-red-300 @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" class="h-4 w-4 text-[#0a2463] focus:ring-[#0a2463] border-gray-300 rounded" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember Me</label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#0a2463] hover:bg-[#1e40af] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0a2463] transition-all duration-200 btn-effect">
                        <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">Computer Service Center Management</p>
                <div class="mt-2 flex justify-center space-x-4">
                    <i class="fas fa-desktop text-[#0a2463]"></i>
                    <i class="fas fa-laptop text-[#1e40af]"></i>
                    <i class="fas fa-mobile-alt text-[#0a2463]"></i>
                    <i class="fas fa-print text-[#1e40af]"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Developer Credit -->
    <div class="mt-8 text-center">
        <p class="text-xs text-gray-500">
            &copy; {{ date('Y') }} Laptop Expert (Pvt) Ltd. All rights reserved. <br>
            <span class="text-gray-400">Developed by olexto Digital Solutions (Pvt) Ltd</span>
        </p>
    </div>
</div>
@endsection 