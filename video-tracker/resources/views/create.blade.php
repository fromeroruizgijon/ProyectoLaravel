<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-800 tracking-tighter uppercase italic">
            NUEVA <span class="text-indigo-600">INCORPORACIÓN</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100"
                 x-data="{ 
                    search: '', 
                    results: [], 
                    selectedGame: null,
                    async fetchGames() {
                        if(this.search.length < 3) { this.results = []; return; }
                        const r = await fetch(`/api/search-igdb?q=${this.search}`);
                        this.results = await r.json();
                    },
                    selectGame(game) {
                        this.selectedGame = game;
                        this.search = game.name;
                        this.results = [];
                        // Rellenamos los campos ocultos y visibles
                        document.getElementById('real_titulo').value = game.name;
                        document.getElementById('genero_select').value = game.genre;
                        document.getElementById('portada_url_hidden').value = game.cover;
                        // Guardamos el ID oficial de IGDB
                        document.getElementById('igdb_id_hidden').value = game.id;
                    }
                 }">
                
                {{-- NUEVO: Bloque de Errores de Validación --}}
                @if ($errors->any())
                    <div class="mb-8 p-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-xl">⚠️</span>
                            <h3 class="font-black text-sm uppercase tracking-widest">Revisa los siguientes errores:</h3>
                        </div>
                        <ul class="list-disc list-inside text-sm font-bold opacity-80">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('videogames.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf 

                    <div class="relative">
                        <label class="block font-black text-xs uppercase tracking-widest text-indigo-600 mb-2">Buscar Videojuego (API IGDB) o Introducir Manualmente</label>
                        
                        {{-- CORRECCIÓN: Usamos AlpineJS para sincronizar lo que escribes con el campo oculto en tiempo real --}}
                        <input type="text" 
                               x-model="search" 
                               @input.debounce.500ms="fetchGames()"
                               class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-800 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm py-4 font-bold" 
                               placeholder="Empieza a escribir para buscar o introduce un título inventado..." autocomplete="off">
                        
                        <div x-show="results.length > 0" class="absolute z-50 w-full bg-white mt-2 rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                            <template x-for="game in results">
                                <div @click="selectGame(game)" class="flex items-center gap-4 p-4 hover:bg-indigo-50 cursor-pointer transition-all border-b border-gray-50">
                                    <img :src="game.cover" class="w-10 h-14 object-cover rounded-lg shadow-sm bg-gray-200">
                                    <div>
                                        <p class="font-black text-gray-800 text-sm" x-text="game.name"></p>
                                        <p class="text-[10px] text-indigo-600 font-bold uppercase" x-text="game.genre"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        {{-- CORRECCIÓN: Le añadimos :value="search" para que siempre tenga el valor del input visible --}}
                        <input type="hidden" name="titulo" id="real_titulo" :value="search" required>
                        <input type="hidden" name="portada_url" id="portada_url_hidden">
                        <input type="hidden" name="igdb_id" id="igdb_id_hidden">
                    </div>

                    <template x-if="selectedGame">
                        <div class="flex items-center gap-4 p-4 bg-green-50 rounded-2xl border border-green-100 animate-pulse">
                            <img :src="selectedGame.cover" class="w-12 h-16 object-cover rounded-lg shadow-md">
                            <div>
                                <p class="text-[10px] font-black text-green-600 uppercase tracking-widest">Juego de API Seleccionado</p>
                                <p class="font-black text-gray-800 italic" x-text="selectedGame.name"></p>
                            </div>
                        </div>
                    </template>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-gray-500 mb-2">Género</label>
                            <select name="genero" id="genero_select" class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-700 font-bold text-sm py-3" required>
                                <option value="" disabled selected>Selecciona categoría</option>
                                <option value="Acción">Acción</option>
                                <option value="Aventura">Aventura</option>
                                <option value="RPG">RPG</option>
                                <option value="Shooter">Shooter</option>
                                <option value="Plataformas">Plataformas</option>
                                <option value="Deportes">Deportes</option>
                                <option value="Estrategia">Estrategia</option>
                                <option value="Terror">Terror</option>
                                <option value="Lucha">Lucha</option>
                                <option value="Simulación">Simulación</option>
                                <option value="Indie">Indie</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-gray-500 mb-2">Plataforma</label>
                            <select name="plataforma" class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-700 font-bold text-sm py-3">
                                <option value="PC">PC</option>
                                <option value="PS5">PlayStation 5</option>
                                <option value="PS4">PlayStation 4</option>
                                <option value="Xbox">Xbox Series X/S</option>
                                <option value="Switch">Nintendo Switch</option>
                                <option value="Retro">Retro</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-gray-500 mb-2">Mi Estado</label>
                            <select name="estado" class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-700 font-bold text-sm py-3">
                                <option value="Pendiente">⏳ Pendiente</option>
                                <option value="Jugando">🕹️ Jugando</option>
                                <option value="Completado">✅ Completado</option>
                                <option value="Abandonado">❌ Abandonado</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-gray-500 mb-2">Puntuación (0-10)</label>
                            <input type="number" name="puntuacion_personal" step="0.1" min="0" max="10" placeholder="Ej: 8.5" class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-700 font-bold py-3" required>
                        </div>
                    </div>

                    <div class="p-6 bg-indigo-50 rounded-2xl border-2 border-dashed border-indigo-100">
                        <label class="block font-black text-xs uppercase tracking-widest text-indigo-600 mb-3 text-center">O sube tu propia carátula (Opcional)</label>
                        <input type="file" name="portada" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer block w-full">
                    </div>

                    <div class="flex items-center justify-center gap-6 pt-6">
                        <a href="{{ route('videogames.index') }}" class="text-xs font-black uppercase text-gray-400 hover:text-gray-600">Volver</a>
                        <button type="submit" class="px-12 py-4 bg-purple-600 hover:bg-purple-700 text-white font-black rounded-xl shadow-lg shadow-purple-200 transition transform active:scale-95 uppercase text-xs tracking-widest">
                            Registrar en mi Biblioteca
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>