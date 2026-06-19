<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel Geospatial')</title>
    <meta name="description" content="@yield('meta_description', 'A high-performance Laravel geospatial web application built with MapLibre GL JS and Tailwind CSS.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
</head>
<body class="h-full bg-white text-slate-900 font-sans antialiased flex flex-col selection:bg-blue-100 selection:text-blue-900">

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between p-4 sm:px-6 lg:px-8">
            <!-- Brand Name -->
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-slate-900 hover:opacity-85 transition-opacity duration-200">
                Laravel Geospatial
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-sm font-semibold transition-colors duration-200 {{ Request::is('/') || Request::is('home') ? 'text-[#0071e3]' : 'text-slate-600 hover:text-slate-900' }}">
                    Home
                </a>
                <a href="{{ url('/map') }}" class="text-sm font-semibold transition-colors duration-200 {{ Request::is('map') ? 'text-[#0071e3]' : 'text-slate-600 hover:text-slate-900' }}">
                    Map
                </a>
            </nav>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-button" type="button" class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 md:hidden focus:outline-none transition-colors duration-200" aria-label="Toggle Menu">
                <svg id="menu-icon-hamburger" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="menu-icon-close" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-b border-slate-200 bg-white">
            <div class="space-y-1 px-4 py-3 sm:px-6">
                <a href="{{ url('/') }}" class="block rounded-lg px-3 py-2 text-base font-semibold transition-colors duration-200 {{ Request::is('/') || Request::is('home') ? 'bg-slate-50 text-[#0071e3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    Home
                </a>
                <a href="{{ url('/map') }}" class="block rounded-lg px-3 py-2 text-base font-semibold transition-colors duration-200 {{ Request::is('map') ? 'bg-slate-50 text-[#0071e3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    Map
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">
                &copy; {{ date('Y') }} Laravel Geospatial. Built for MAPID Internship.
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('menu-icon-hamburger');
            const closeIcon = document.getElementById('menu-icon-close');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    const isHidden = mobileMenu.classList.toggle('hidden');
                    if (isHidden) {
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    } else {
                        hamburgerIcon.classList.add('hidden');
                        closeIcon.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
