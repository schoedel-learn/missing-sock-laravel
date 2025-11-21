@extends('layouts.app')

@section('title', 'Login - The Missing Sock Photography')

@section('content')
<div 
    class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12"
    x-data="{
        submitting: false,
        email: '{{ old('email') }}',
        isValidEmail: false,
        touched: false,
    }"
>
    <div class="w-full max-w-md">
        <!-- Logo & Heading -->
        <div class="text-center mb-8">
            <img 
                src="{{ asset('assets/graphics/login-kids-grid.webp') }}" 
                alt="Smiling children on picture day - The Missing Sock Photography" 
                class="w-full mx-auto mb-6 rounded-xl"
            >
            <h1 class="text-3xl font-bold text-gray-900 mb-3">
                Sign in to your account
            </h1>
            <p class="text-sm text-gray-600">
                Don't have an account? 
                <a 
                    href="{{ route('pre-order.start') }}" 
                    class="font-semibold text-primary hover:text-primary-hover underline decoration-2 underline-offset-2 transition-colors duration-200"
                >
                    Register for picture day
                </a>
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form class="space-y-6" action="{{ route('login') }}" method="POST" @submit="submitting = true">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email address
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autofocus
                            autocomplete="email" 
                            required 
                            x-ref="emailInput"
                            x-model="email"
                            @blur="touched = true"
                            @input="isValidEmail = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/.test(email)"
                            @keydown.enter.prevent="$refs.passwordInput.focus()"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 pr-12 text-base border rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200 @error('email') border-red-300 @enderror"
                            :class="{
                                'border-gray-300': !touched,
                                'border-green-400 bg-green-50 focus:ring-green-500': touched && isValidEmail,
                                'border-red-400 bg-red-50 focus:ring-red-500': touched && !isValidEmail && email.length > 0
                            }"
                            placeholder="you@example.com"
                        >
                        <!-- Success checkmark -->
                        <div 
                            x-show="touched && isValidEmail" 
                            x-transition
                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                        >
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <p 
                        x-show="touched && !isValidEmail && email.length > 0" 
                        x-transition
                        class="mt-2 text-sm text-red-600"
                    >
                        Please enter a valid email address
                    </p>
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
                        x-ref="passwordInput"
                        @keydown.enter=""
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
                    x-ref="submitButton"
                    :disabled="submitting"
                    class="w-full min-h-[52px] py-4 px-6 text-base font-semibold text-white bg-primary hover:bg-primary-hover active:bg-primary-dark rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 active:translate-y-0 transition-butter hover-lift focus:outline-none focus:ring-4 focus:ring-primary/30 disabled:bg-primary/70 disabled:cursor-not-allowed"
                >
                    <span x-show="!submitting" class="flex items-center justify-center">
                        Sign in
                    </span>
                    <span x-show="submitting" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Signing you in...
                    </span>
                </button>
            </form>

            <!-- Minimal, helpful footer with actual contact info -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 text-center leading-relaxed">
                    First time? Use the registration link above. Already registered? Use your email to sign in.
                    <span class="block sm:inline mt-1 sm:mt-0">
                        Need help? Email 
                        <a 
                            href="mailto:info@themissingsock.photo" 
                            class="text-primary hover:text-primary-hover font-medium underline whitespace-nowrap"
                        >
                            info@themissingsock.photo
                        </a>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Full-page overlay during transition -->
    <div 
        x-show="submitting"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 bg-white bg-opacity-90 backdrop-blur-sm z-50 flex items-center justify-center"
    >
        <div class="text-center">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-4 border-primary mb-4"></div>
            <p class="text-lg font-medium text-gray-700">Loading your dashboard...</p>
        </div>
    </div>
</div>
@endsection

