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
                    <p class="text-sm text-gray-500 uppercase font-bold">Total Juegos</p>
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
                    <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center shadow-sm">
                        <span class="mr-2">📝</span> Últimas incorporaciones
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($ultimosJuegos as $juego)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold mr-4">
                                        {{ substr($juego->titulo, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $juego->titulo }}</p>
                                        <p class="text-xs text-gray-500">{{ $juego->genero }} • {{ $juego->plataforma }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-indigo-600">{{ $juego->puntuacion_media }}/10</span>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $juego->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('videogames.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 underline">
                            Ver toda la biblioteca →
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
