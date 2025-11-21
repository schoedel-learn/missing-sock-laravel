<footer class="bg-white text-gray-700">
    <div class="container-custom py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo & Description -->
            <div class="md:col-span-2">
                <div class="flex items-center mb-4">
                    <img 
                        src="{{ asset('assets/graphics/primary-nav-heading-logo-top-left.webp') }}" 
                        alt="The Missing Sock Photography" 
                        class="h-12 w-auto"
                    >
                </div>
                <p class="text-gray-600 mb-4 max-w-md">
                    Professional school photography services serving 149+ schools across Miami and South Florida. 
                    Capturing beautiful memories since 2020.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors" aria-label="Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors" aria-label="Instagram">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-900">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Home</a></li>
                    <li><a href="{{ route('home') }}#about" class="text-gray-600 hover:text-gray-900 transition-colors">About Us</a></li>
                    <li><a href="{{ route('home') }}#packages" class="text-gray-600 hover:text-gray-900 transition-colors">Packages</a></li>
                    <li><a href="{{ route('home') }}#faq" class="text-gray-600 hover:text-gray-900 transition-colors">FAQ</a></li>
                    <li><a href="{{ route('pre-order.start') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Pre-Order</a></li>
                    <li>
                        @auth
                            <a href="{{ route('filament.user.pages.dashboard') }}" class="text-gray-600 hover:text-gray-900 transition-colors">My Account</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition-colors font-medium">Login</a>
                        @endauth
                    </li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-900">Contact Us</h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:info@themissingsock.photo" class="hover:text-gray-900 transition-colors">
                            info@themissingsock.photo
                        </a>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+1234567890" class="hover:text-gray-900 transition-colors">
                            (123) 456-7890
                        </a>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Miami & South Florida</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-gray-200 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} The Missing Sock Photography. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-gray-900 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-900 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-gray-900 transition-colors">Cancellation & Refund Policy</a>
            </div>
        </div>
    </div>
</footer>

