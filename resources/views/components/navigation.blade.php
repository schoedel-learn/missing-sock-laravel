<nav class="bg-background-main shadow-md sticky top-0 z-50">
    <div class="container-custom">
        <div class="flex items-center justify-between h-20 gap-8">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img 
                        src="{{ asset('assets/graphics/primary-nav-heading-logo-top-left.webp') }}" 
                        alt="The Missing Sock Photography" 
                        class="h-12 md:h-14 w-auto"
                        loading="eager"
                    >
                </a>
            </div>
            
            <!-- Desktop Navigation - Centered with flex gap-6 for primary menu -->
            <nav class="hidden md:flex items-center justify-center flex-1" aria-label="Main navigation">
                <div class="flex gap-6">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('home') }}#about" class="nav-link">
                        About Us
                    </a>
                    <a href="{{ route('home') }}#packages" class="nav-link">
                        Packages
                    </a>
                    <a href="{{ route('home') }}#faq" class="nav-link">
                        FAQ
                    </a>
                    <a href="{{ route('home') }}#contact" class="nav-link">
                        Contact
                    </a>
                </div>
            </nav>
            
            <!-- Login/Account Section - Right Aligned -->
            <div class="hidden md:flex items-center gap-4 flex-shrink-0">
                @auth
                    <a href="{{ route('filament.user.pages.dashboard') }}" class="nav-link whitespace-nowrap">
                        My Account
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary text-sm whitespace-nowrap">
                        Login
                    </a>
                @endauth
                
                <!-- CTA Button -->
                <x-ui.button href="{{ route('pre-order.start') }}" variant="primary" class="uppercase whitespace-nowrap">
                    REGISTER FOR PICTURE DAY!
                </x-ui.button>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button 
                    type="button" 
                    id="mobile-menu-button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger icon -->
                    <svg class="h-6 w-6" id="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close icon (hidden by default) -->
                    <svg class="h-6 w-6 hidden" id="close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu (hidden by default) -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">
                Home
            </a>
            <a href="{{ route('home') }}#about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">
                About Us
            </a>
            <a href="{{ route('home') }}#packages" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">
                Packages
            </a>
            <a href="{{ route('home') }}#faq" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">
                FAQ
            </a>
            <a href="{{ route('home') }}#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">
                Contact
            </a>
            @auth
                <a href="{{ route('filament.user.pages.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">
                    My Account
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary w-full justify-center text-sm mt-1">
                    Login
                </a>
            @endauth
            <a href="{{ route('pre-order.start') }}" class="block px-3 py-2 rounded-md text-base font-medium bg-primary text-white hover:bg-primary-hover text-center mt-4 uppercase transition-colors">
                REGISTER FOR PICTURE DAY!
            </a>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                
                mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
                menuIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
        }
        
        // Close mobile menu when clicking on a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            });
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    });
</script>
@endpush

