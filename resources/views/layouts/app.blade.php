<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IFZ Tech') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Css Stacks --}}
    @stack('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tambahkan Flowbite (jika belum) -->
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    {{-- Navbar --}}
    @include('layouts.navigation')


    {{-- Konten utama --}}
    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            @if (isset($header))
                <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                    {{ $header }}
                </div>
            @endif
            {{ $slot }}
        </div>
    </div>

    {{-- Javascript Stacks --}}
    @stack('js')
</body>

</html>
