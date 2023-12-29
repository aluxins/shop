<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ !empty($title) ? $title.' - ' : '' }}{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/dropdown-menu.css'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">


            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow flex flex-row items-center pl-1 lg:p-5 justify-start">
                    {{ $header }}
                </header>
            @endif

                <!-- Page Content -->
                <main class="w-full lg:max-w-[1180px] mx-auto">

                    <!-- Page Title -->
                    @if (isset($heading))
                        <h2 class="font-semibold text-xl text-center pt-6 text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $heading }}
                        </h2>
                    @endif

                    <div class="mt-12 mx-5">
                        {{ $slot }}
                    </div>
                </main>
        </div>
    </body>
</html>
