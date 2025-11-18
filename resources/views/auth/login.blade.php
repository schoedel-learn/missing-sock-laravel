@extends('layouts.app')

@section('title', 'Login - The Missing Sock Photography')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Logo & Heading -->
        <div class="text-center mb-8">
            <img 
                src="{{ asset('assets/logos/LOGO_LOGOLARGE-74.webp') }}" 
                alt="The Missing Sock Photography" 
                class="h-16 mx-auto mb-4"
            >
            <h1 class="text-2xl font-bold text-gray-900">
                Sign in to your account
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                Or 
                <a href="{{ route('pre-order.start') }}" class="font-medium text-primary hover:text-primary-hover">
                    register for picture day
                </a>
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email address
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 text-base border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200 @error('email') border-red-300 @enderror"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        autocomplete="current-password" 
                        required
                        class="w-full px-4 py-3 text-base border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200 @error('password') border-red-300 @enderror"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="flex items-center cursor-pointer">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary"
                        >
                        <span class="ml-2 text-sm text-gray-700">Remember me</span>
                    </label>

                    <a href="/my-account/password/reset/request" class="text-sm font-medium text-primary hover:text-primary-hover">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit -->
                <button 
                    type="submit" 
                    class="w-full py-3.5 px-6 text-base font-semibold text-white bg-primary hover:bg-primary-hover rounded-lg transition-colors duration-200 shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                >
                    Sign in
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

