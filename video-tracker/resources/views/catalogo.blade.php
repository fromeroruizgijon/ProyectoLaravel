<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-800">🎮 Catálogo de la Comunidad</h2>
                
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        🔍
                    </span>
                    <input type="text" id="buscador" placeholder="Buscar por título o género..." 
                           class="w-full pl-10 pr-4 py-2 rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                </div>
            </div>
            
            <div id="contenedor-juegos" class="grid grid-cols-1 gap-4">
                @foreach ($juegosGlobales as $game)
                <div class="juego-card bg-white p-4 rounded-xl shadow flex items-center justify-between hover:shadow-md transition-shadow"
                     data-titulo="{{ strtolower($game->titulo) }}" 
                     data-genero="{{ strtolower($game->genero) }}">
                    
                    <div class="flex items-center">
                        <div class="w-16 h-20 mr-4 flex-shrink-0">
                            @if($game->portada)
                                <img src="{{ asset('storage/' . $game->portada) }}" class="w-full h-full object-cover rounded shadow-sm">
                            @else
                                <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-[10px] text-gray-400">Sin foto</div>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-bold text-lg text-gray-800">{{ $game->titulo }}</h3>
                            <p class="text-gray-500 text-sm">
                                {{ $game->genero }} • 
                                <span class="text-indigo-600 font-bold">
                                    ⭐ Media: {{ number_format($game->notaMedia(), 1) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('videogames.votar', $game->id) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="number" name="puntuacion_personal" step="0.1" min="0" max="10" placeholder="Nota" 
                                   class="w-20 rounded-lg border-gray-300 text-sm focus:ring-indigo-500" required>
                            
                            <select name="estado" class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500">
                                <option value="Pendiente">⏳ Pendiente</option>
                                <option value="Jugando">🕹️ Jugando</option>
                                <option value="Completado">✅ Completado</option>
                                <option value="Abandonado">❌ Abandonado</option>
                            </select>

                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition shadow-sm active:transform active:scale-95">
                                Votar/Añadir
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>

            <div id="paginacion-container" class="mt-6">
                {{ $juegosGlobales->links() }}
            </div>
        </div>
    </div>

    <script>
        document.getElementById('buscador').addEventListener('input', function(e) {
            let filtro = e.target.value.toLowerCase();
            let tarjetas = document.querySelectorAll('.juego-card');
            let paginacion = document.getElementById('paginacion-container');

            tarjetas.forEach(tarjeta => {
                let titulo = tarjeta.getAttribute('data-titulo');
                let genero = tarjeta.getAttribute('data-genero');

                if (titulo.includes(filtro) || genero.includes(filtro)) {
                    tarjeta.style.display = 'flex';
                } else {
                    tarjeta.style.display = 'none';
                }
            });

            // Ocultar paginación mientras se busca para no confundir
            if (filtro.length > 0) {
                paginacion.style.opacity = '0.3';
                paginacion.style.pointerEvents = 'none';
            } else {
                paginacion.style.opacity = '1';
                paginacion.style.pointerEvents = 'auto';
            }
        });
    </script>
</x-app-layout>