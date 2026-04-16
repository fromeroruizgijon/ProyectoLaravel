<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-800 tracking-tighter uppercase italic">
            PANEL DE <span class="text-purple-600">CONTROL</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white p-8 rounded-3xl shadow-sm border-b-4 border-indigo-500">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">Mi Colección</p>
                    <p class="text-4xl font-black text-gray-800 mt-1">{{ $stats['total'] }} <span class="text-indigo-500 text-lg italic">Juegos</span></p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border-b-4 border-purple-500">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">En Partida</p>
                    <p class="text-4xl font-black text-gray-800 mt-1">{{ $stats['jugando'] }} <span class="text-purple-500 text-lg italic">Jugando</span></p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border-b-4 border-green-500">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">Misiones Completadas</p>
                    <p class="text-4xl font-black text-gray-800 mt-1">{{ $stats['completados'] }} <span class="text-green-500 text-lg italic">Listos</span></p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-[2rem] border border-gray-100">
                <div class="p-8">
                    <h3 class="text-xl font-black text-gray-800 mb-8 flex items-center uppercase tracking-tight italic">
                        <span class="text-purple-600 mr-3">⚡</span> Últimas incorporaciones globales
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($ultimosJuegosGlobales as $juego)
                            <div class="group flex items-center justify-between p-5 bg-gray-50 rounded-2xl border border-transparent hover:border-purple-200 hover:bg-white hover:shadow-md transition-all">
                                <div class="flex items-center">
                                    <div class="w-14 h-20 mr-6 flex-shrink-0">
                                        {{-- LÓGICA DE IMAGEN CORREGIDA --}}
                                        @if($juego->portada_url)
                                            <img src="{{ $juego->portada_url }}" class="w-full h-full object-cover rounded-xl border border-gray-100 shadow-sm">
                                        @elseif($juego->portada)
                                            <img src="{{ asset('storage/' . $juego->portada) }}" class="w-full h-full object-cover rounded-xl border border-gray-100 shadow-sm">
                                        @else
                                            <div class="w-full h-full bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center font-black text-xl border border-purple-200 uppercase italic">
                                                {{ substr($juego->titulo, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <p class="font-black text-lg text-gray-800 group-hover:text-purple-600 transition-colors italic">
                                            <a href="{{ route('games.show', $juego->id) }}">{{ $juego->titulo }}</a>
                                        </p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $juego->genero }}</p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span class="text-2xl font-black text-indigo-600 italic">
                                        {{ number_format($juego->notaMedia() ?? 0, 1) }}
                                    </span>
                                    <p class="text-[9px] text-gray-400 uppercase font-black mt-1">Nota Media</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10 flex justify-center gap-6">
                        <a href="{{ route('videogames.catalogo') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 transform active:scale-95">
                            Explorar Catálogo
                        </a>
                        <a href="{{ route('videogames.index') }}" class="px-8 py-3 text-gray-400 hover:text-purple-600 text-xs font-black uppercase tracking-widest transition">
                            Mi Inventario →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>