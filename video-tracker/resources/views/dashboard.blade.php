<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-indigo-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Total en mi Colección</p>
                    <p class="text-3xl font-black">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">En Proceso 🕹️</p>
                    <p class="text-3xl font-black text-yellow-600">{{ $stats['jugando'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Completados ✅</p>
                    <p class="text-3xl font-black text-green-600">{{ $stats['completados'] }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center">
                        <span class="mr-2">🌍</span> Últimos juegos añadidos al sistema
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($ultimosJuegosGlobales as $juego)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <div class="w-12 h-16 mr-4 flex-shrink-0">
                                        @if($juego->portada)
                                            <img src="{{ asset('storage/' . $juego->portada) }}" class="w-full h-full object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-full h-full bg-indigo-100 text-indigo-600 rounded flex items-center justify-center font-bold">
                                                {{ substr($juego->titulo, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $juego->titulo }}</p>
                                        <p class="text-xs text-gray-500">{{ $juego->genero }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase mt-1">Incorporado recientemente</p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <div class="flex flex-col items-end">
                                        <span class="text-lg font-black text-indigo-600">
                                            ⭐ {{ number_format($juego->notaMedia(), 1) }}
                                        </span>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-tighter">
                                            Media de la Comunidad
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-center gap-4">
                        <a href="{{ route('videogames.catalogo') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-indigo-700 transition">
                            Ir al Catálogo para Votar
                        </a>
                        <a href="{{ route('videogames.index') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 py-2 transition">
                            Ver mi biblioteca →
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
