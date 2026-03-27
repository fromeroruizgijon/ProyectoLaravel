<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-3xl p-8 border border-gray-100">
                <div class="flex flex-col md:flex-row gap-12">
                    
                    <div class="w-full md:w-1/3">
                        <div class="bg-gray-50 p-3 rounded-3xl border border-gray-100 shadow-inner">
                            @if($juego->portada)
                                <img src="{{ asset('storage/' . $juego->portada) }}" class="w-full rounded-2xl shadow-lg border border-white">
                            @else
                                <div class="w-full aspect-[3/4] bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 font-bold">Sin Imagen</div>
                            @endif
                        </div>
                        
                        <div class="mt-6 bg-purple-600 p-6 rounded-3xl text-center shadow-lg shadow-purple-200">
                            <p class="text-[10px] text-purple-100 uppercase font-black tracking-widest">Media Comunidad</p>
                            <p class="text-6xl font-black text-white leading-none mt-1">{{ number_format($juego->notaMedia(), 1) }}</p>
                        </div>
                    </div>

                    <div class="w-full md:w-2/3 flex flex-col">
                        <div class="mb-8">
                            <span class="bg-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border border-indigo-200">
                                {{ $juego->genero }}
                            </span>
                            <h1 class="text-5xl font-black text-gray-800 mt-4 tracking-tighter italic leading-none">{{ $juego->titulo }}</h1>
                        </div>

                        <div class="flex-grow">
                            <h3 class="font-bold text-gray-400 mb-4 text-xs uppercase tracking-widest flex items-center">
                                <span class="mr-2">👥</span> Usuarios que lo juegan
                            </h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @forelse($juego->videogames as $voto)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-purple-600 rounded-full mr-3 flex items-center justify-center text-[10px] font-black text-white uppercase italic">
                                                {{ substr($voto->user->name, 0, 1) }}
                                            </div>
                                            <p class="text-sm font-bold text-gray-700">{{ $voto->user->name }}</p>
                                        </div>
                                        <span class="font-black text-purple-600">{{ number_format($voto->puntuacion_personal, 1) }}</span>
                                    </div>
                                @empty
                                    <p class="text-gray-400 text-sm italic">Nadie lo ha añadido aún.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-gray-50">
                            <a href="{{ route('videogames.catalogo') }}" class="text-gray-400 font-bold hover:text-purple-600 transition-colors text-sm">← Volver al catálogo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>