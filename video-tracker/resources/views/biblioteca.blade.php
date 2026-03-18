<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-indigo-700 leading-tight">
                {{ __('🎮 Mi Colección Personal') }}
            </h2>
            <div class="mb-6 flex justify-end">
                <a href="{{ route('videogames.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
                    + Añadir Nuevo Juego
                </a>
            </div>
            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $videojuegos->count() }} Juegos
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold uppercase text-sm">Título</th>
                            <th class="px-6 py-4 font-semibold uppercase text-sm text-center">Género</th>
                            <th class="px-6 py-4 font-semibold uppercase text-sm text-center">Plataforma</th>
                            <th class="px-6 py-4 font-semibold uppercase text-sm text-right">Puntuación</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($videojuegos as $juego)
                        <tr class="hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $juego->titulo }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $colores = [
                                        'Pendiente' => 'bg-gray-100 text-gray-800',
                                        'Jugando' => 'bg-yellow-100 text-yellow-800 animate-pulse',
                                        'Completado' => 'bg-green-100 text-green-800',
                                        'Abandonado' => 'bg-red-100 text-red-800'
                                    ];
                                    $iconos = [
                                        'Pendiente' => '⏳',
                                        'Jugando' => '🕹️',
                                        'Completado' => '✅',
                                        'Abandonado' => '❌'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colores[$juego->estado] ?? 'bg-gray-100' }}">
                                    {{ $iconos[$juego->estado] ?? '' }} {{ $juego->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $juego->genero }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                <span class="flex justify-center items-center gap-1">
                                    {{ $juego->plataforma }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($juego->estado == 'Jugando')
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 italic animate-pulse">
                                        🕹️ {{ $juego->estado }}
                                    </span>
                                @elseif($juego->estado == 'Completado')
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        ✅ {{ $juego->estado }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                        {{ $juego->estado }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-mono font-bold {{ $juego->puntuacion_media >= 8 ? 'text-green-600' : 'text-orange-500' }}">
                                    {{ $juego->puntuacion_media }}/10
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>