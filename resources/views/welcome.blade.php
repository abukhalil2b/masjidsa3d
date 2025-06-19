<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>الملتقيات التعليمية</title>

    <!-- Arabic Fonts: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] font-['Tajawal']">
    <!-- Header -->
    <header class="w-full flex justify-end items-center p-4 max-w-4xl mx-auto">
        @if (Route::has('login'))
            <nav class="flex items-center space-x-reverse space-x-4">
                @auth
                    <a 
                        href="{{ url('/dashboard') }}" 
                        class="group flex items-center space-x-2 space-x-reverse text-sm rounded-full border border-gray-300 dark:border-[#3E3E3A] px-4 py-2 hover:border-[#1915014a] dark:hover:border-[#62605b] transition"
                    >
                        <span class="inline-block">📊</span> 
                        <span>لوحة التحكم</span>
                    </a>
                @else
                    <a 
                        href="{{ route('login') }}" 
                        class="group flex items-center space-x-2 space-x-reverse text-sm rounded-full border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] px-4 py-2 transition"
                    >
                        <span class="inline-block">🔐</span> 
                        <span>تسجيل الدخول</span>
                    </a>
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto text-center py-20">
        <h1 class="text-2xl sm:text-3xl font-bold mb-6">عَلِّمُوا أَوْلادَكُمُ الْقُرْآنَ فَإِنَّهُ أَوَّلُ مَا يَنْبَغِي أَنْ يُتَعَلَّمَ مِنْ عِلْمِ اللَّهِ هُوَ</h1>
       
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-gray-200 py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} جميع الحقوق محفوظة.
    </footer>
</body>

</html>
