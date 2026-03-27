<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-800 tracking-tighter uppercase leading-tight italic">
            ACTUALIZAR <span class="text-purple-600">REGISTRO</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
                <div class="mb-8 border-b border-gray-50 pb-6 text-center">
                     <p class="text-sm text-gray-400 uppercase font-bold tracking-widest">Editando ficha de:</p>
                     <h3 class="text-2xl font-black text-indigo-600 italic mt-1">{{ $videojuego->game->titulo }}</h3>
                </div>

                <form action="{{ route('videogames.update', $videojuego->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-gray-500 mb-2">Plataforma</label>
                            <select name="plataforma" class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-700 focus:ring-purple-500 focus:border-purple-500 shadow-sm font-bold text-sm py-3">
                                <option value="PC" {{ $videojuego->plataforma == 'PC' ? 'selected' : '' }}>PC</option>
                                <option value="PS5" {{ $videojuego->plataforma == 'PS5' ? 'selected' : '' }}>PlayStation 5</option>
                                <option value="PS4" {{ $videojuego->plataforma == 'PS4' ? 'selected' : '' }}>PlayStation 4</option>
                                <option value="Xbox" {{ $videojuego->plataforma == 'Xbox' ? 'selected' : '' }}>Xbox Series X/S</option>
                                <option value="Switch" {{ $videojuego->plataforma == 'Switch' ? 'selected' : '' }}>Nintendo Switch</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-gray-500 mb-2">Estado del juego</label>
                            <select name="estado" class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-700 focus:ring-purple-500 focus:border-purple-500 shadow-sm font-bold text-sm py-3">
                                <option value="Pendiente" {{ $videojuego->estado == 'Pendiente' ? 'selected' : '' }}>⏳ Pendiente (Backlog)</option>
                                <option value="Jugando" {{ $videojuego->estado == 'Jugando' ? 'selected' : '' }}>🕹️ Jugando ahora</option>
                                <option value="Completado" {{ $videojuego->estado == 'Completado' ? 'selected' : '' }}>✅ Completado al 100%</option>
                                <option value="Abandonado" {{ $videojuego->estado == 'Abandonado' ? 'selected' : '' }}>❌ Abandonado</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-purple-50 p-8 rounded-3xl border border-purple-100">
                        <label class="block font-black text-xs uppercase tracking-widest text-purple-700 mb-4 text-center">Tu puntuación personal (0 - 10)</label>
                        <div class="flex items-center justify-center">
                            <input type="number" name="puntuacion_personal" step="0.1" value="{{ $videojuego->puntuacion_personal }}" 
                                   class="w-40 rounded-2xl bg-white border-purple-200 text-center text-5xl font-black text-purple-600 focus:ring-purple-500 focus:border-purple-500 shadow-md h-24"
                                   required>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-6 pt-6">
                        <a href="{{ route('videogames.index') }}" class="px-6 py-3 text-gray-400 hover:text-gray-600 text-xs font-black uppercase tracking-widest transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-10 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-purple-200 transition transform active:scale-95">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>