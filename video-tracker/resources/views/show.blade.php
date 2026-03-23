<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10 text-center md:text-left">
                <span class="bg-purple-500/10 text-purple-400 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border border-purple-500/20">
                    {{ $juego->genero }}
                </span>
                <h1 class="text-6xl font-black text-white mt-4 tracking-tighter leading-none shadow-sm shadow-black/50">
                    {{ $juego->titulo }}
                </h1>
            </div>

            <div class="flex flex-col lg:flex-row gap-10">
                
                <div class="w-full lg:w-2/5 flex flex-col gap-6">
                    <div class="bg-slate-900 p-3 rounded-3xl border border-slate-800 shadow-2xl shadow-purple-500/10">
                        @if($juego->portada)
                            <img src="{{ asset('storage/' . $juego->portada) }}" class="w-full h-auto object-cover rounded-2xl shadow-xl shadow-black/70 border border-slate-700">
                        @else
                            <div class="w-full aspect-[3/4] bg-slate-800 rounded-2xl flex items-center justify-center text-xl text-slate-600 font-bold uppercase border border-slate-700 italic">
                                No Portada
                            </div>
                        @endif
                    </div>
                    
                    <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800 shadow-2xl shadow-cyan-500/10 text-center relative overflow-hidden group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-600 to-purple-600 rounded-3xl blur opacity-10 group-hover:opacity-20 transition duration-1000 group-hover:duration-200"></div>
                        
                        <div class="relative">
                            <p class="text-xs text-cyan-400 uppercase font-black tracking-widest">Global Community Rating</p>
                            <p class="text-8xl font-black text-white leading-none mt-2 italic shadow-lg shadow-black/50">
                                {{ number_format($juego->notaMedia(), 1) }}
                            </p>
                            <p class="text-[10px] text-slate-500 mt-2 uppercase tracking-tight">Based on {{ $juego->videogames->count() }} individual logs</p>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-3/5 bg-slate-900 p-10 rounded-[2rem] border border-slate-800 shadow-2xl shadow-purple-500/5 flex flex-col">
                    <h3 class="font-black text-3xl text-white mb-8 flex items-center tracking-tight uppercase">
                        <span class="text-purple-500 mr-3">👥</span> User Database
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 overflow-y-auto pr-2 max-h-[35rem]">
                        @forelse($juego->videogames as $voto)
                            <div class="flex items-center justify-between p-5 bg-slate-800/50 rounded-2xl border border-slate-700/50 hover:bg-slate-800 hover:border-cyan-500/30 transition-all">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-slate-700 rounded-full mr-4 flex items-center justify-center text-xs font-black text-cyan-400 uppercase italic border border-cyan-500/30">
                                        {{ substr($voto->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-white">{{ $voto->user->name }}</p>
                                        @php
                                            $colores = [
                                                'Pendiente' => 'text-slate-500',
                                                'Jugando' => 'text-cyan-400 animate-pulse',
                                                'Completado' => 'text-purple-400',
                                                'Abandonado' => 'text-red-400'
                                            ];
                                        @endphp
                                        <p class="text-[10px] uppercase font-bold tracking-widest mt-0.5 {{ $colores[$voto->estado] ?? 'text-slate-500' }}">
                                            {{ $voto->estado }}
                                        </p>
                                    </div>
                                </div>
                                <span class="font-black text-2xl text-cyan-400 italic">{{ number_format($voto->puntuacion_personal, 1) }}</span>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 flex flex-col items-center justify-center text-center py-10 bg-slate-800/40 rounded-2xl border-2 border-dashed border-slate-700">
                                <span class="text-6xl mb-4">👻</span>
                                <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">No user has this item yet.</p>
                                <p class="text-[10px] text-slate-600 mt-1">Be the first to log it!</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-auto pt-10 border-t border-slate-800">
                        <a href="{{ route('videogames.catalogo') }}" class="px-6 py-2.5 bg-slate-800 text-slate-400 hover:text-white rounded-xl text-xs font-black uppercase tracking-widest transition transform active:scale-95 inline-flex items-center">
                            ← Return to Database
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>