<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GameVault') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-950">
            
            <div class="mb-8 text-center px-4">
                <h1 class="text-5xl font-black text-white tracking-tighter shadow-sm">
                    <span class="text-cyan-400">Video</span><span class="text-purple-500">Tracker</span>
                </h1>
                <p class="text-slate-400 text-sm mt-3 uppercase tracking-widest font-bold">Inicia Partida</p>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-slate-900 border border-indigo-500/20 shadow-2xl shadow-purple-500/10 overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
