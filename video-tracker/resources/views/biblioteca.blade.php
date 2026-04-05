<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-3xl text-gray-800 tracking-tighter italic">
                MI <span class="text-purple-600">BIBLIOTECA</span>
            </h2>
            <div class="flex items-center gap-4">
                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full border border-purple-200 shadow-sm">
                    {{ $videojuegos->count() }} JUEGOS EN TOTAL
                </span>
                <a href="{{ route('videogames.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-xl shadow-md transition transform active:scale-95 uppercase text-xs tracking-widest">
                    + AÑADIR JUEGO
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-wrap gap-3 mb-8">
                <button onclick="filtrarBiblioteca('todos', this)" class="filter-btn bg-purple-600 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-md transition-all">
                    Todos
                </button>
                <button onclick="filtrarBiblioteca('Jugando', this)" class="filter-btn bg-white text-gray-600 border border-gray-100 px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-green-50 transition-all">
                    🎮 Jugando
                </button>
                <button onclick="filtrarBiblioteca('Completado', this)" class="filter-btn bg-white text-gray-600 border border-gray-100 px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-purple-50 transition-all">
                    🏆 Hechos
                </button>
                <button onclick="filtrarBiblioteca('Pendiente', this)" class="filter-btn bg-white text-gray-600 border border-gray-100 px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-100 transition-all">
                    ⏳ Pendientes
                </button>
            </div>

            <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-200">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-purple-600 font-bold uppercase text-xs tracking-widest">
                            <th class="px-6 py-4">Visual</th>
                            <th class="px-6 py-4">Título</th>
                            <th class="px-6 py-4 text-center">Género</th>
                            <th class="px-6 py-4 text-center">Plataforma</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4 text-right">Nota</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-biblioteca" class="divide-y divide-gray-100">
                        @foreach ($videojuegos as $juego)
                        <tr class="fila-juego hover:bg-purple-50/50 transition-colors duration-200 text-gray-700" data-estado="{{ $juego->estado }}">
                            <td class="px-6 py-4 text-center">
                                {{-- PRIORIDAD DE IMAGEN: API -> LOCAL -> NADA --}}
                                @if($juego->game->portada_url)
                                    <img src="{{ $juego->game->portada_url }}" class="w-12 h-16 object-cover rounded-lg shadow-sm border border-gray-200 mx-auto">
                                @elseif($juego->game->portada)
                                    <img src="{{ asset('storage/' . $juego->game->portada) }}" class="w-12 h-16 object-cover rounded-lg shadow-sm border border-gray-200 mx-auto">
                                @else
                                    <div class="w-12 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-[10px] text-gray-400 border border-gray-200 uppercase font-bold text-center mx-auto">Sin imagen</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800 italic">
                                <a href="{{ route('games.show', $juego->game->id) }}" class="hover:text-purple-600 transition-colors">{{ $juego->game->titulo }}</a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $juego->game->genero }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 font-medium">{{ $juego->plataforma }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $colores = [
                                        'Pendiente' => 'bg-gray-100 text-gray-600 border-gray-200',
                                        'Jugando' => 'bg-green-50 text-green-700 border-green-200',
                                        'Completado' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'Abandonado' => 'bg-red-50 text-red-700 border-red-200'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase border {{ $colores[$juego->estado] ?? 'bg-gray-50' }}">
                                    {{ $juego->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-mono text-lg font-black {{ $juego->puntuacion_personal >= 8 ? 'text-purple-600' : 'text-gray-600' }}">
                                    {{ number_format($juego->puntuacion_personal, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3 text-lg">
                                    <a href="{{ route('videogames.edit', $juego->id) }}" class="text-gray-400 hover:text-indigo-600 transition-colors">✏️</a>
                                    <form action="{{ route('videogames.destroy', $juego->id) }}" method="POST" onsubmit="return confirm('¿Borrar de la biblioteca?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function filtrarBiblioteca(estado, btn) {
            const filas = document.querySelectorAll('.fila-juego');
            const botones = document.querySelectorAll('.filter-btn');

            botones.forEach(b => {
                b.classList.remove('bg-purple-600', 'text-white', 'shadow-md');
                b.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-100');
            });
            btn.classList.add('bg-purple-600', 'text-white', 'shadow-md');
            btn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-100');

            filas.forEach(fila => {
                if (estado === 'todos' || fila.getAttribute('data-estado') === estado) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>