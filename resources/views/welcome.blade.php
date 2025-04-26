<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen font-sans">

    <!-- Header -->
    <header class="bg-white dark:bg-[#121212] shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-[#1b1b18] dark:text-white">Student Clinic Management System</h1>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="text-sm px-4 py-2 rounded border border-gray-300 dark:border-gray-600 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm px-4 py-2 rounded text-[#1b1b18] dark:text-white hover:underline">
                            Log in
                        </a>
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center px-6 py-12">
        <div class="space-y-6 text-center">
            <a href="{{ route('reception.register.patient') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-3 rounded shadow transition">
                Register Patient
            </a>

            <div class="">
                <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-white"></h2>
                <p class="text-gray-600 dark:text-gray-400"></p>
            </div>

            <a href="{{ route('admin.register.user') }}"
               class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-6 py-3 rounded shadow transition">
                Register User
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-[#121212] border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-600 dark:text-gray-400">
            &copy; {{ date('Y') }} Student Clinic Management System. All rights reserved.
        </div>
    </footer>

</body>
</html>
