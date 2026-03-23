<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-white tracking-tighter uppercase">
            Command <span class="text-cyan-400">Center</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-slate-900 p-6 rounded-3xl shadow-xl border-b-4 border-indigo-500/50">
                    <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Storage Capacity</p>
                    <p class="text-4xl font-black text-white mt-1">{{ $stats['total'] }} <span class="text-indigo-500 text-lg">Games</span></p>
                </div>
                <div class="bg-slate-900 p-6 rounded-3xl shadow-xl border-b-4 border-cyan-500/50">
                    <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Active Quests</p>
                    <p class="text-4xl font-black text-white mt-1">{{ $stats['jugando'] }} <span class="text-cyan-500 text-lg text-pulse">Playing</span></p>
                </div>
                <div class="bg-slate-900 p-6 rounded-3xl shadow-xl border-b-4 border-purple-500/50">
                    <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Trophies Earned</p>
                    <p class="text-4xl font-black text-white mt-1">{{ $stats['completados'] }} <span class="text-purple-500 text-lg text-pulse">Cleared</span></p>
                </div>
            </div>

            <div class="bg-slate-900 overflow-hidden shadow-2xl rounded-[2rem] border border-slate-800">
                <div class="p-8">
                    <h3 class="text-xl font-black text-white mb-8 flex items-center uppercase tracking-tight">
                        <span class="text-cyan-400 mr-3">⚡</span> World Feed: New Entries
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($ultimosJuegosGlobales as $juego)
                            <div class="group flex items-center justify-between p-5 bg-slate-800/40 rounded-2xl border border-slate-700/50 hover:bg-slate-800 hover:border-cyan-500/30 transition-all">
                                <div class="flex items-center">
                                    <div class="w-14 h-20 mr-6 flex-shrink-0">
                                        @if($juego->portada)
                                            <img src="{{ asset('storage/' . $juego->portada) }}" class="w-full h-full object-cover rounded-xl border border-slate-600 shadow-lg">
                                        @else
                                            <div class="w-full h-full bg-slate-700 text-cyan-400 rounded-xl flex items-center justify-center font-black text-xl border border-slate-600 uppercase italic">
                                                {{ substr($juego->titulo, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <p class="font-black text-lg text-white group-hover:text-cyan-400 transition-colors">
                                            <a href="{{ route('games.show', $juego->id) }}">{{ $juego->titulo }}</a>
                                        </p>
                                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ $juego->genero }}</p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span class="text-2xl font-black text-purple-500 italic shadow-purple-500/20">
                                        {{ number_format($juego->notaMedia(), 1) }}
                                    </span>
                                    <p class="text-[9px] text-slate-500 uppercase font-black mt-1">Global Score</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10 flex justify-center gap-6">
                        <a href="{{ route('videogames.catalogo') }}" class="px-8 py-3 bg-cyan-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-cyan-500 transition shadow-lg shadow-cyan-600/20 transform active:scale-95">
                            Enter Database
                        </a>
                        <a href="{{ route('videogames.index') }}" class="px-8 py-3 text-slate-400 hover:text-white text-xs font-black uppercase tracking-widest transition">
                            Back to Inventory →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
