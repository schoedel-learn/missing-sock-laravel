<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Missing Sock Photography') }} - @yield('title', 'School Photography Pre-Orders')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Professional school photography services in Miami and South Florida. Pre-order your child\'s school pictures today!')">
    <meta name="keywords" content="school photography, Miami, South Florida, children photography, school pictures">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'The Missing Sock Photography')">
    <meta property="og:description" content="@yield('og_description', 'Professional school photography services')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="antialiased">
    <!-- Navigation -->
    @include('components.navigation')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('components.footer')
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>

