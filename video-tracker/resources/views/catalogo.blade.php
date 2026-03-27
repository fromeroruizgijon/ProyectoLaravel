<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-6">
                <h2 class="text-3xl font-black text-gray-800 tracking-tighter uppercase italic">
                    Archivo <span class="text-purple-600">Global</span>
                </h2>
                
                <form id="search-form" action="{{ route('videogames.catalogo') }}" method="GET" class="relative w-full md:w-96 group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">🔍</span>
                    <input type="text" 
                           name="search" 
                           id="search-input"
                           value="{{ request('search') }}" 
                           placeholder="Escribe para buscar..." 
                           oninput="this.form.submit()"
                           class="w-full pl-12 pr-4 py-3 bg-white border-gray-200 text-gray-800 rounded-2xl shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all placeholder:text-gray-400">
                    
                    @if(request('search') || request('genero'))
                        <a href="{{ route('videogames.catalogo') }}" class="absolute inset-y-0 right-0 pr-10 flex items-center text-gray-300 hover:text-red-500 transition-colors">
                            ✕
                        </a>
                    @endif
                    <input type="hidden" name="genero" value="{{ request('genero') }}">
                </form>
            </div>

            <div class="flex flex-wrap gap-2 mb-10 justify-center md:justify-start">
                @php
                    $categorias = ['Acción', 'Aventura', 'RPG', 'Shooter', 'Deportes', 'Estrategia', 'Terror'];
                @endphp
                
                <a href="{{ route('videogames.catalogo', ['search' => request('search')]) }}" 
                   class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('genero') ? 'bg-purple-600 text-white shadow-md' : 'bg-white text-gray-500 border border-gray-100 hover:bg-purple-50' }}">
                   Todos
                </a>

                @foreach($categorias as $cat)
                    <a href="{{ route('videogames.catalogo', ['genero' => $cat, 'search' => request('search')]) }}" 
                       class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('genero') == $cat ? 'bg-purple-600 text-white shadow-md' : 'bg-white text-gray-500 border border-gray-100 hover:bg-purple-50' }}">
                       {{ $cat }}
                    </a>
                @endforeach
            </div>
            
            @if($juegosGlobales->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <span class="text-6xl">👾</span>
                    <p class="mt-4 text-gray-500 font-bold uppercase tracking-widest">No hay juegos en esta categoría</p>
                    <a href="{{ route('videogames.catalogo') }}" class="text-purple-600 underline mt-2 inline-block">Limpiar filtros</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
                    @foreach ($juegosGlobales as $game)
                    <div class="juego-card bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center hover:shadow-xl hover:border-purple-200 transition-all duration-300">
                        
                        <div class="w-32 h-44 mb-4">
                            @if($game->portada)
                                <img src="{{ asset('storage/' . $game->portada) }}" class="w-full h-full object-cover rounded-2xl shadow-md border border-gray-100">
                            @else
                                <div class="w-full h-full bg-gray-100 rounded-2xl flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase border border-gray-200">Sin foto</div>
                            @endif
                        </div>

                        <h3 class="font-black text-xl text-gray-800 tracking-tight text-center">
                            <a href="{{ route('games.show', $game->id) }}" class="hover:text-purple-600 transition-colors italic">{{ $game->titulo }}</a>
                        </h3>
                        
                        <div class="flex items-center gap-2 mt-1 mb-4">
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">{{ $game->genero }}</span>
                            <span class="text-purple-600 font-black text-sm">⭐ {{ number_format($game->notaMedia(), 1) }}</span>
                        </div>

                        <form action="{{ route('videogames.votar', $game->id) }}" method="POST" class="w-full border-t border-gray-50 pt-4">
                            @csrf
                            <div class="flex flex-col gap-2">
                                <div class="flex gap-2">
                                    <input type="number" name="puntuacion_personal" step="0.1" min="0" max="10" placeholder="Nota" 
                                           class="w-1/3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-purple-500 py-2" required>
                                    
                                    <select name="estado" class="w-2/3 bg-gray-50 border-gray-200 rounded-xl text-[10px] font-bold uppercase focus:ring-purple-500 py-2">
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Jugando">Jugando</option>
                                        <option value="Completado">Hecho</option>
                                    </select>
                                </div>

                                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-purple-700 transition shadow-sm active:scale-95">
                                    Añadir a mi lista
                                </button>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $juegosGlobales->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        const input = document.getElementById('search-input');
        if (input.value.length > 0) {
            input.focus();
            const val = input.value;
            input.value = '';
            input.value = val;
        }
    </script>
</x-app-layout>