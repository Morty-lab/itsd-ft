<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Add this to include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Meraki UI CSS -->
    <link href="https://cdn.jsdelivr.net/npm/meraki-ui/dist/meraki-ui.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
<div class="min-h-screen">
    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $header }}</h1>
            </div>
        </header>
    @endisset

    <!-- Main Content -->
    <main class="px-4 sm:px-6 lg:px-8 py-6">
        <!-- Card Example from Meraki UI -->
{{--        <div class="meraki-card shadow-md bg-white dark:bg-gray-800 p-6 mb-6 rounded-lg">--}}
{{--            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Welcome to {{ config('app.name', 'Laravel') }}</h2>--}}
{{--            <p class="text-gray-600 dark:text-gray-400 mt-2">--}}
{{--                This is a modern, responsive layout styled with Meraki UI components.--}}
{{--            </p>--}}
{{--            <a href="#" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Get Started</a>--}}
{{--        </div>--}}

        <!-- Dynamic Page Content (Slot) -->
        <div class="space-y-6">
            {{ $slot }}
        </div>
    </main>
</div>

<script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>
</html>
