@extends('layouts.app')

@section('title', 'School Photography Pre-Orders')
@section('description', 'Professional school photography services serving 149+ schools across Miami and South Florida. Pre-order your child\'s school pictures today!')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-light via-white to-accent-pink-light overflow-hidden">
    <div class="container-custom py-20 md:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Column: Text Content -->
            <div class="animate-slideUp">
                <h1 class="hero-heading mb-6">
                    Capture Every
                    <span class="text-gradient-primary">Precious Moment</span>
                </h1>
                <p class="text-xl text-gray-700 mb-8 leading-relaxed">
                    Professional school photography serving 149+ schools across Miami and South Florida. 
                    Pre-order your child's pictures today and unlock exclusive benefits!
                </p>
                
                <!-- Benefits List -->
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-success mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-800"><strong>Pre-Pay & Save</strong> - Exclusive discounts and packages</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-success mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-800"><strong>5-Day Selection</strong> - Choose your favorite images online</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-success mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-800"><strong>Free School Delivery</strong> - Or fast home shipping for $7</span>
                    </li>
                </ul>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('pre-order.start') }}" class="btn btn-primary btn-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Start Your Pre-Order
                    </a>
                    <a href="#packages" class="btn btn-secondary btn-lg">
                        View Packages
                    </a>
                </div>
                
                <!-- Trust Badge -->
                <div class="mt-8 flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-success" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Trusted by 149+ schools • 10,000+ happy families</span>
                </div>
            </div>
            
            <!-- Right Column: Image -->
            <div class="relative animate-scaleIn">
                <div class="relative z-10">
                    <img 
                        src="{{ asset('images/hero-children.jpg') }}" 
                        alt="Happy children school photography"
                        class="rounded-2xl shadow-2xl w-full"
                    >
                </div>
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-accent-warm opacity-20 rounded-full blur-3xl -z-0"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-primary opacity-20 rounded-full blur-3xl -z-0"></div>
            </div>
        </div>
    </div>
    
    <!-- Wave separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- Schools We Serve -->
<section class="section bg-white" id="about">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Serving Schools Across South Florida
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                We partner with 149+ preschools, elementary schools, and academies throughout Miami-Dade, Broward, and Palm Beach counties.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Stat Card 1 -->
            <div class="card card-hover text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-light rounded-full mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">149+</h3>
                <p class="text-gray-600">Partner Schools</p>
            </div>
            
            <!-- Stat Card 2 -->
            <div class="card card-hover text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-success-light rounded-full mb-4">
                    <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">10,000+</h3>
                <p class="text-gray-600">Happy Families</p>
            </div>
            
            <!-- Stat Card 3 -->
            <div class="card card-hover text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-accent-warm-light rounded-full mb-4">
                    <svg class="w-8 h-8 text-accent-warm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">5+ Years</h3>
                <p class="text-gray-600">Experience</p>
            </div>
        </div>
    </div>
</section>

<!-- Packages Section -->
<section class="section bg-gray-50" id="packages">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Choose Your Perfect Package
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                From simple digital downloads to comprehensive print packages, we have options for every family.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Package 1: Digital Duo -->
            <div class="card card-hover">
                <div class="bg-gradient-primary text-white text-center py-4 -mx-6 -mt-6 mb-6 rounded-t-xl">
                    <h3 class="text-2xl font-bold">Digital Duo</h3>
                    <p class="text-3xl font-bold mt-2">$55</p>
                </div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>2 Digital Poses</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>High-resolution downloads</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Perfect for printing at home</span>
                    </li>
                </ul>
                <a href="{{ route('pre-order.start') }}" class="btn btn-secondary w-full">
                    Select Package
                </a>
            </div>
            
            <!-- Package 2: Popular Pair (Featured) -->
            <div class="card card-hover relative border-2 border-accent-warm">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-accent-warm text-white px-4 py-1 rounded-full text-sm font-semibold">
                        Most Popular
                    </span>
                </div>
                <div class="bg-gradient-warm text-white text-center py-4 -mx-6 -mt-6 mb-6 rounded-t-xl">
                    <h3 class="text-2xl font-bold">Popular Pair</h3>
                    <p class="text-3xl font-bold mt-2">$65</p>
                </div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>2 Poses with Prints</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Multiple print sizes</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Free school delivery</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Best value for families</span>
                    </li>
                </ul>
                <a href="{{ route('pre-order.start') }}" class="btn btn-primary w-full">
                    Select Package
                </a>
            </div>
            
            <!-- Package 3: Fantastic Four -->
            <div class="card card-hover">
                <div class="bg-gradient-primary text-white text-center py-4 -mx-6 -mt-6 mb-6 rounded-t-xl">
                    <h3 class="text-2xl font-bold">Fantastic Four</h3>
                    <p class="text-3xl font-bold mt-2">$124</p>
                </div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>4 Poses with Prints</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Premium print packages</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Digital downloads included</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-success mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Maximum variety</span>
                    </li>
                </ul>
                <a href="{{ route('pre-order.start') }}" class="btn btn-secondary w-full">
                    Select Package
                </a>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('pre-order.start') }}" class="btn btn-primary btn-lg">
                View All Packages & Start Pre-Order
            </a>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="section bg-white">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                How It Works
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Four simple steps to beautiful school photos
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary text-white rounded-full text-2xl font-bold mb-4">
                    1
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Pre-Order Online</h3>
                <p class="text-gray-600">
                    Select your school, choose your package, and complete payment securely online.
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary text-white rounded-full text-2xl font-bold mb-4">
                    2
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Picture Day</h3>
                <p class="text-gray-600">
                    Our professional photographers visit your child's school on the scheduled date.
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary text-white rounded-full text-2xl font-bold mb-4">
                    3
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Choose Your Favorites</h3>
                <p class="text-gray-600">
                    Access your private online gallery and select your favorite poses within 5 days.
                </p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary text-white rounded-full text-2xl font-bold mb-4">
                    4
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Receive & Enjoy</h3>
                <p class="text-gray-600">
                    Get your professional prints delivered to school or home within 3-4 weeks.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section bg-gray-50" id="faq">
    <div class="container-custom max-w-4xl">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Frequently Asked Questions
            </h2>
        </div>
        
        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <details class="card cursor-pointer" open>
                <summary class="font-semibold text-lg text-gray-900 flex justify-between items-center cursor-pointer">
                    What if I'm not satisfied with the photos?
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <p class="mt-4 text-gray-600">
                    We offer a satisfaction guarantee! If you're not happy with your photos, we'll work with you to retake them or provide a full refund. Your satisfaction is our priority.
                </p>
            </details>
            
            <!-- FAQ Item 2 -->
            <details class="card cursor-pointer">
                <summary class="font-semibold text-lg text-gray-900 flex justify-between items-center cursor-pointer">
                    Can I register without pre-paying?
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <p class="mt-4 text-gray-600">
                    Yes! You can register your child for picture day without pre-paying. However, pre-paying unlocks exclusive packages, discounts, and benefits that aren't available otherwise.
                </p>
            </details>
            
            <!-- FAQ Item 3 -->
            <details class="card cursor-pointer">
                <summary class="font-semibold text-lg text-gray-900 flex justify-between items-center cursor-pointer">
                    How long does delivery take?
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <p class="mt-4 text-gray-600">
                    Free school delivery takes 3-4 weeks after the photo session. Home shipping is available for $7 and arrives in 6-10 business days after you select your images.
                </p>
            </details>
            
            <!-- FAQ Item 4 -->
            <details class="card cursor-pointer">
                <summary class="font-semibold text-lg text-gray-900 flex justify-between items-center cursor-pointer">
                    Can I order for multiple children?
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <p class="mt-4 text-gray-600">
                    Absolutely! You can register up to 3 children in a single order. We also offer a Sibling Special for just $5 extra where siblings can pose together.
                </p>
            </details>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section bg-gradient-primary text-white" id="contact">
    <div class="container-custom text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">
            Ready to Capture Beautiful Memories?
        </h2>
        <p class="text-xl mb-8 opacity-90">
            Start your pre-order today and save on professional school photography
        </p>
        <a href="{{ route('pre-order.start') }}" class="btn bg-white text-primary hover:bg-gray-100 btn-lg">
            Start Pre-Order Now
        </a>
        
        <div class="mt-12 pt-12 border-t border-white/20">
            <p class="text-lg mb-4">Have questions? We're here to help!</p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-6 text-white/90">
                <a href="mailto:info@themissingsock.photo" class="flex items-center hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    info@themissingsock.photo
                </a>
                <a href="tel:+1234567890" class="flex items-center hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    (123) 456-7890
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

