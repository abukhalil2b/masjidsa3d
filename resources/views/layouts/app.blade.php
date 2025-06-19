<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { /* keeping your color variables */
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --dark: #1e1e24;
            --light: #f8f9fa;
        }
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f7fb;
        }
        .sidebar-icon { width: 1.5rem; height: 1.5rem; stroke-width: 1.5; }
        .nav-item.active { background-color: var(--primary-light); color: var(--primary); border-right: 3px solid var(--primary); border-left: none; }
        .nav-item.active .sidebar-icon { color: var(--primary); }
        .user-avatar { width: 2.5rem; height: 2.5rem; background-color: var(--primary-light); color: var(--primary); }

        /* Mobile bottom navigation */
        .mobile-nav {
            display: flex; /* Always show bottom nav */
            position: fixed; bottom: 0; right: 0; left: 0;
            background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 40; /* Ensure it's above content */
        }
        .mobile-nav-item { flex: 1; padding: 0.75rem; text-align: center; color: #6b7280; }
        .mobile-nav-item.active { color: var(--primary); }
        .mobile-nav-icon { width: 1.5rem; height: 1.5rem; margin: 0 auto; }

        /* Adjust main content padding for the fixed bottom navigation */
        .main-content { padding-bottom: 5rem; /* Space for mobile nav */ }
    </style>
</head>
<body class="antialiased">
    <div class="flex h-screen overflow-hidden">
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse ml-auto"> {{-- Use ml-auto to push to right for RTL --}}
                       <button id="user-menu-button-mobile" class="p-1 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none block">
                            <svg class="w-7 h-7 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0012 11z" clip-rule="evenodd"></path></svg>
                        </button>
                        <button class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </button>
                        <div class="relative hidden sm:block">
                            <input type="text" placeholder="بحث..." class="pl-10 pr-4 py-2 border rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <svg class="absolute right-3 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 main-content">
                @isset($header)
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $header }}</h1>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <a href="{{ route('dashboard') }}" class="hover:text-primary">{{ __('الرئيسية') }}</a>
                        {{-- Use a left-arrow icon for RTL breadcrumbs --}}
                        <svg class="w-4 h-4 mx-2 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        <span>{{ $header }}</span>
                    </div>
                </div>
                @endisset
                {{ $slot }}
            </main>
        </div>

        <nav class="mobile-nav">
            <a href="{{ route('student_groups') }}" class="mobile-nav-item {{ request()->routeIs('student_groups') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round"
        d="M17 20h5v-2a3 3 0 00-3-3h-2m-4-6a4 4 0 100-8 4 4 0 000 8zm6 6v2m0 0a3 3 0 01-3-3H7a3 3 0 01-3 3v2h16zM7 20v-2a3 3 0 00-3-3H3" />
</svg>
                <span class="block text-xs mt-1">المجموعات</span>
            </a>
            <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="block text-xs mt-1">{{ __('الرئيسية') }}</span>
            </a>
            <a href="{{ route('tasks.index') }}" class="mobile-nav-item {{ request()->routeIs('tasks.*') || request()->routeIs('student-tasks.*') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span class="block text-xs mt-1">{{ __('المهام') }}</span>
            </a>
            <a href="{{ route('attendances.index') }}" class="mobile-nav-item {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="block text-xs mt-1">{{ __('الحضور') }}</span>
            </a>
            {{-- NEW: Mobile link to Evaluate Student Tasks Page --}}
            <a href="{{ route('tasks.evaluate.index') }}" class="mobile-nav-item {{ request()->routeIs('tasks.evaluate.*') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12.75l3 3m0 0l3-3m-3 3v2.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="block text-xs mt-1">{{ __('تقييم') }}</span>
            </a>
        </nav>

        <div id="user-menu" class="w-56 bg-white rounded-md shadow-lg py-1 hidden z-50 absolute">
            <div class="px-4 py-3">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
            <div class="border-t border-gray-100"></div>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary flex items-center">
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ __('الملف الشخصي') }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                   class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary flex items-center">
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    {{ __('تسجيل الخروج') }}
                </a>
            </form>
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // User Menu Elements
            const userMenu = document.getElementById('user-menu');
            const userMenuButtonMobile = document.getElementById('user-menu-button-mobile');

            // --- User Menu Functions ---
            function closeUserMenu() {
                if (userMenu && !userMenu.classList.contains('hidden')) {
                    userMenu.classList.add('hidden');
                    // Reset inline styles
                    userMenu.style.position = '';
                    userMenu.style.top = '';
                    userMenu.style.bottom = '';
                    userMenu.style.left = '';
                    userMenu.style.right = '';
                    userMenu.style.transform = '';
                }
            }

            // Toggle user dropdown on mobile user menu button click
            if (userMenuButtonMobile && userMenu) {
                userMenuButtonMobile.addEventListener('click', function (event) {
                    event.stopPropagation(); // Prevent document click from immediately closing

                    const isHidden = userMenu.classList.toggle('hidden');
                    if (!isHidden) {
                        // Position fixed relative to viewport for header
                        userMenu.style.position = 'fixed';
                        const headerRect = document.querySelector('header').getBoundingClientRect();
                        userMenu.style.top = (headerRect.bottom + 8) + 'px'; // Below header, 8px margin
                        userMenu.style.right = '1rem'; // Align to the right
                        userMenu.style.left = 'auto'; // Clear left
                        userMenu.style.bottom = 'auto'; // Clear bottom
                    }
                });
            }

            // --- Global Click Listener for closing menus ---
            document.addEventListener('click', function(event) {
                // Close User Menu if click is outside
                if (userMenu && !userMenu.classList.contains('hidden')) {
                    const isClickInsideUserMenu = userMenu.contains(event.target);
                    const isClickOnMobileButton = userMenuButtonMobile && userMenuButtonMobile.contains(event.target);

                    if (!isClickInsideUserMenu && !isClickOnMobileButton) {
                        closeUserMenu();
                    }
                }
            });

            // Close menus on Escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeUserMenu();
                }
            });

            // Close user menu on resize to prevent awkward positioning
            window.addEventListener('resize', function() {
                closeUserMenu();
            });
        });
    </script>
</body>
</html>