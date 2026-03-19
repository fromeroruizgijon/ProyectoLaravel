<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('🚀 Añadir a la Enciclopedia Global') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                
                <form action="{{ route('videogames.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf 

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2 text-indigo-700">Título del Videojuego</label>
                        <input type="text" name="titulo" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: God of War" required>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase">⚠️ Si el nombre ya existe, se usará la ficha actual y se añadirá a tu colección.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Género Principal</label>
                            <select name="genero" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" disabled selected>Selecciona un género</option>
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

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tu Plataforma</label>
                            <select name="plataforma" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="PC">PC</option>
                                <option value="PS5">PlayStation 5</option>
                                <option value="PS4">PlayStation 4</option>
                                <option value="Xbox">Xbox Series X/S</option>
                                <option value="Switch">Nintendo Switch</option>
                                <option value="Retro">Consola Retro</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tu Estado</label>
                        <select name="estado" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Pendiente">⏳ Pendiente</option>
                            <option value="Jugando">🕹️ Jugando</option>
                            <option value="Completado">✅ Completado</option>
                            <option value="Abandonado">❌ Abandonado</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tu Nota (0-10)</label>
                            <input type="number" name="puntuacion_personal" step="0.1" min="0" max="10" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Subir Portada</label>
                            <input type="file" name="portada" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 pt-4 border-t">
                        <a href="{{ route('videogames.index') }}" class="text-sm text-gray-600 underline mr-4">Volver</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition transform active:scale-95">
                            💾 Registrar Videojuego
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>