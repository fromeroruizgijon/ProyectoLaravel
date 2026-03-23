<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-3xl text-white tracking-tighter">
                {{ __('MY') }} <span class="text-cyan-400">INVENTORY</span>
            </h2>
            <div class="flex items-center gap-4">
                <span class="bg-slate-800 text-cyan-400 text-xs font-bold px-3 py-1 rounded-full border border-cyan-500/30 shadow-sm shadow-cyan-500/20">
                    {{ $videojuegos->count() }} SLOTS OCCUPIED
                </span>
                <a href="{{ route('videogames.create') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-black py-2 px-6 rounded-xl shadow-lg shadow-purple-500/20 transition transform active:scale-95 uppercase text-xs tracking-widest">
                    + ADD NEW LOOT
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 shadow-2xl rounded-3xl overflow-hidden border border-slate-800">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-800/50 border-b border-slate-700 text-cyan-400">
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-widest">Visual</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-widest">Title</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-widest text-center">Genre</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-widest text-center">Platform</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-widest text-right">Score</th>
                            <th class="px-6 py-4 font-black uppercase text-xs tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach ($videojuegos as $juego)
                        <tr class="hover:bg-indigo-500/5 transition-colors duration-200">
                            <td class="px-6 py-4">
                                @if($juego->game->portada)
                                    <img src="{{ asset('storage/' . $juego->game->portada) }}" class="w-12 h-16 object-cover rounded-lg shadow-md shadow-black/50 border border-slate-700">
                                @else
                                    <div class="w-12 h-16 bg-slate-800 rounded-lg flex items-center justify-center text-[10px] text-slate-500 border border-slate-700 uppercase font-bold">No Data</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-100">
                                <a href="{{ route('games.show', $juego->game->id) }}" class="hover:text-cyan-400 transition-colors">{{ $juego->game->titulo }}</a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-slate-800 text-cyan-400 border border-cyan-500/20">
                                    {{ $juego->game->genero }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-slate-400 font-medium">{{ $juego->plataforma }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $colores = [
                                        'Pendiente' => 'bg-slate-800 text-slate-400 border-slate-700',
                                        'Jugando' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/30 animate-pulse',
                                        'Completado' => 'bg-purple-500/10 text-purple-400 border-purple-500/30',
                                        'Abandonado' => 'bg-red-500/10 text-red-400 border-red-500/30'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase border {{ $colores[$juego->estado] ?? 'bg-slate-800' }}">
                                    {{ $juego->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-mono text-lg font-black {{ $juego->puntuacion_personal >= 8 ? 'text-cyan-400' : 'text-purple-400' }}">
                                    {{ number_format($juego->puntuacion_personal, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('videogames.edit', $juego->id) }}" class="text-slate-500 hover:text-cyan-400 transition-colors text-xl">✏️</a>
                                    <form action="{{ route('videogames.destroy', $juego->id) }}" method="POST" onsubmit="return confirm('¿Eliminar objeto del inventario?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-slate-500 hover:text-red-500 transition-colors text-xl">🗑️</button>
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
</x-app-layout>