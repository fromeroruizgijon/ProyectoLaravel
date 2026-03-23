<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Global <span class="text-purple-500">Database</span></h2>
                
                <div class="relative w-full md:w-96 group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-cyan-400">🔍</span>
                    <input type="text" id="buscador" placeholder="Search by title or category..." 
                           class="w-full pl-12 pr-4 py-3 bg-slate-900 border-slate-700 text-white rounded-2xl shadow-inner focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all placeholder:text-slate-600">
                </div>
            </div>
            
            <div id="contenedor-juegos" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($juegosGlobales as $game)
                <div class="juego-card bg-slate-900 p-5 rounded-3xl border border-slate-800 flex flex-col sm:flex-row items-center justify-between hover:border-cyan-500/50 hover:shadow-lg hover:shadow-cyan-500/5 transition-all duration-300"
                     data-titulo="{{ strtolower($game->titulo) }}" 
                     data-genero="{{ strtolower($game->genero) }}">
                    
                    <div class="flex items-center w-full">
                        <div class="w-20 h-28 mr-6 flex-shrink-0">
                            @if($game->portada)
                                <img src="{{ asset('storage/' . $game->portada) }}" class="w-full h-full object-cover rounded-xl shadow-2xl border border-slate-700">
                            @else
                                <div class="w-full h-full bg-slate-800 rounded-xl flex items-center justify-center text-[10px] text-slate-600 font-bold uppercase border border-slate-700">No Image</div>
                            @endif
                        </div>

                        <div class="flex-grow">
                            <h3 class="font-black text-xl text-white tracking-tight">
                                <a href="{{ route('games.show', $game->id) }}" class="hover:text-cyan-400 transition-colors">{{ $game->titulo }}</a>
                            </h3>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-slate-500 text-xs font-bold uppercase tracking-wider">{{ $game->genero }}</span>
                                <span class="text-purple-400 font-black text-sm">⭐ {{ number_format($game->notaMedia(), 1) }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('videogames.votar', $game->id) }}" method="POST" class="mt-4 sm:mt-0 w-full sm:w-auto">
                        @csrf
                        <div class="flex flex-row gap-2">
                            <input type="number" name="puntuacion_personal" step="0.1" min="0" max="10" placeholder="Score" 
                                   class="w-20 bg-slate-800 border-slate-700 text-white rounded-xl text-xs focus:ring-purple-500" required>
                            
                            <select name="estado" class="bg-slate-800 border-slate-700 text-white rounded-xl text-[10px] font-bold uppercase focus:ring-purple-500 py-1">
                                <option value="Pendiente">Wait</option>
                                <option value="Jugando">Play</option>
                                <option value="Completado">Done</option>
                            </select>

                            <button type="submit" class="bg-gradient-to-br from-cyan-500 to-blue-600 text-white p-2 rounded-xl shadow-lg shadow-cyan-500/20 hover:from-cyan-400 hover:to-blue-500 transition transform active:scale-90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>

            <div id="paginacion-container" class="mt-12 opacity-80">
                {{ $juegosGlobales->links() }}
            </div>
        </div>
    </div>
    </x-app-layout>