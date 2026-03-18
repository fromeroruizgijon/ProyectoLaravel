<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Añadir Nuevo Videojuego') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 border border-gray-100">
                
                <form action="{{ route('videogames.store') }}" method="POST">
                    @csrf <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Título del Juego</label>
                        <input type="text" name="titulo" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: Zelda: Breath of the Wild" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Género</label>
                            <input type="text" name="genero" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: RPG, Acción..." required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Plataforma</label>
                            <select name="plataforma" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="PC">PC</option>
                                <option value="PS5">PlayStation 5</option>
                                <option value="Xbox">Xbox Series X/S</option>
                                <option value="Switch">Nintendo Switch</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2 text-indigo-700">Estado actual</label>
                        <select name="estado" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Pendiente">⏳ Pendiente</option>
                            <option value="Jugando">🕹️ Jugando</option>
                            <option value="Completado">✅ Completado</option>
                            <option value="Abandonado">❌ Abandonado</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Puntuación (0-10)</label>
                        <input type="number" name="puntuacion_media" step="0.1" min="0" max="10" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('videogames.index') }}" class="text-sm text-gray-600 underline mr-4">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition">
                            Guardar Videojuego
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>