<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'JobPilot') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen bg-[#f0f4f8] flex">
            <!-- Sidebar Global -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <main class="flex-1 flex flex-col h-screen overflow-hidden">
                <!-- Header Global -->
                @include('layouts.header')

                @if(session('success'))
                    <div class="mx-10 mt-4 mb-2 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-10 mt-4 mb-2 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Conteúdo da Página Específica -->
                <div class="flex-1 overflow-y-auto px-10 pb-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
