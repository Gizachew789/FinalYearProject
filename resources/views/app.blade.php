<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BiT Students Clinic')</title>

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
            <h1 class="text-xl font-semibold text-[#1b1b18] dark:text-white">BiT Students Clinic</h1>
            <a href="{{ route('login') }}" class="text-sm px-4 py-2 rounded text-[#1b1b18] dark:text-white hover:underline">Log in</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
            <div class="container">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'BiT Students Clinic') }}. All rights reserved.</p>
            </div>
        </footer>

</body>
</html>
