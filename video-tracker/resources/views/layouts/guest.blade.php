<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'VideoTracker') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
            
            <div class="mb-8 text-center px-4">
                <h1 class="text-5xl font-black tracking-tighter shadow-sm">
                    <span class="text-indigo-600">Video</span><span class="text-purple-600">Tracker</span>
                </h1>
                <p class="text-gray-500 text-sm mt-3 uppercase tracking-widest font-bold italic">Inicia Partida</p>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white border border-purple-100 shadow-xl shadow-purple-500/5 overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
