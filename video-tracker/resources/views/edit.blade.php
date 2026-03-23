<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-white tracking-tighter uppercase leading-tight">
            UPDATE <span class="text-purple-500">ITEM</span> DATALOG:
            <span class="text-cyan-400 italic block mt-1 normal-case font-bold text-lg">{{ $videojuego->game->titulo }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl shadow-purple-500/10 border border-slate-800 relative overflow-hidden group">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-[2.5rem] blur opacity-5 group-hover:opacity-10 transition duration-1000"></div>
                
                <form action="{{ route('videogames.update', $videojuego->id) }}" method="POST" class="relative space-y-8">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-cyan-400 mb-2">Platform Slot</label>
                            <select name="plataforma" class="w-full rounded-xl bg-slate-800 border-slate-700 text-white focus:ring-purple-500 focus:border-purple-500 shadow-inner font-bold text-sm">
                                <option value="PC" {{ $videojuego->plataforma == 'PC' ? 'selected' : '' }}>PC Master Race</option>
                                <option value="PS5" {{ $videojuego->plataforma == 'PS5' ? 'selected' : '' }}>PlayStation 5</option>
                                <option value="Xbox" {{ $videojuego->plataforma == 'Xbox' ? 'selected' : '' }}>Xbox Series X/S</option>
                                <option value="Switch" {{ $videojuego->plataforma == 'Switch' ? 'selected' : '' }}>Nintendo Switch</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block font-black text-xs uppercase tracking-widest text-cyan-400 mb-2">Quest Status</label>
                            <select name="estado" class="w-full rounded-xl bg-slate-800 border-slate-700 text-white focus:ring-purple-500 focus:border-purple-500 shadow-inner font-bold text-sm">
                                <option value="Pendiente" {{ $videojuego->estado == 'Pendiente' ? 'selected' : '' }}>⏳ On Hold / Backlog</option>
                                <option value="Jugando" {{ $videojuego->estado == 'Jugando' ? 'selected' : '' }}>🕹️ Currently Playing</option>
                                <option value="Completado" {{ $videojuego->estado == 'Completado' ? 'selected' : '' }}>✅ Mission Cleared</option>
                                <option value="Abandonado" {{ $videojuego->estado == 'Abandonado' ? 'selected' : '' }}>❌ Quest Failed / Rage Quit</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-slate-800/60 p-6 rounded-2xl border border-slate-700/50">
                        <label class="block font-black text-sm uppercase tracking-widest text-white mb-3 text-center">Personal Experience Score (0 - 10)</label>
                        <div class="relative flex items-center justify-center">
                            <span class="absolute left-6 text-4xl font-black text-purple-500 italic">Score:</span>
                            <input type="number" name="puntuacion_personal" step="0.1" value="{{ $videojuego->puntuacion_personal }}" 
                                   class="w-full rounded-2xl bg-slate-800 border-slate-700 text-right text-6xl font-black text-cyan-400 italic focus:ring-purple-500 focus:border-purple-500 shadow-inner pr-8 pl-40 h-28"
                                   required>
                        </div>
                        <p class="text-[10px] text-slate-600 mt-2 text-center uppercase">Adjust your rating using the inputs above.</p>
                    </div>

                    <div class="flex items-center justify-center gap-6 mt-10 pt-8 border-t border-slate-800">
                        <a href="{{ route('videogames.index') }}" class="px-6 py-3 bg-slate-800 text-slate-400 hover:text-white rounded-xl text-xs font-black uppercase tracking-widest transition transform active:scale-95 inline-flex items-center">
                            × Discard Changes / Back
                        </a>
                        <button type="submit" class="px-10 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-purple-500/20 transition transform active:scale-95">
                            💾 Commit Updates (Save)
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>