<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-800 tracking-tighter uppercase italic">
            NUEVA <span class="text-indigo-600">INCORPORACIÓN</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
                
                <form action="{{ route('videogames.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf 

                    <div>
                        <label class="block font-black text-xs uppercase tracking-widest text-indigo-600 mb-2">Título del Videojuego</label>
                        <input type="text" name="titulo" class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-800 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm py-3 font-bold" placeholder="Ej: Elden Ring" required>
                        <p class="text-[10px] text-gray-400 mt-2 uppercase font-bold tracking-tighter">Nota: Si el juego ya existe, se usará la ficha global y se añadirá a tu lista.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-gray-500 mb-2">Género</label>
                            <select name="genero" class="w-full rounded-xl bg-gray-50 border-gray-200 text-gray-700 font-bold text-sm py-3" required>
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

                    <div class="p-6 bg-indigo-50 rounded-2xl border-2 border-dashed border-indigo-100 text-center">
                        <label class="block font-black text-xs uppercase tracking-widest text-indigo-600 mb-3 text-center">Imagen de Portada</label>
                        <input type="file" name="portada" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                    </div>

                    <div class="flex items-center justify-center gap-6 pt-6">
                        <a href="{{ route('videogames.index') }}" class="text-xs font-black uppercase text-gray-400 hover:text-gray-600">Volver</a>
                        <button type="submit" class="px-12 py-4 bg-purple-600 hover:bg-purple-700 text-white font-black rounded-xl shadow-lg shadow-purple-200 transition transform active:scale-95 uppercase text-xs tracking-widest">
                            Registrar en Base de Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>