<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[3rem] shadow-xl overflow-hidden border border-gray-100 mb-12">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 bg-gray-100">
                        @if($juego->portada_url)
                            <img src="{{ $juego->portada_url }}" class="w-full h-full object-cover shadow-2xl">
                        @elseif($juego->portada)
                            <img src="{{ asset('storage/' . $juego->portada) }}" class="w-full h-full object-cover shadow-2xl">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 font-black uppercase italic text-center px-4 py-20">
                                👾 <br> Sin Imagen
                            </div>
                        @endif
                    </div>

                    <div class="md:w-2/3 p-10 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-purple-600 font-black text-xs uppercase tracking-widest bg-purple-50 px-3 py-1 rounded-lg">{{ $juego->genero }}</span>
                                    <h2 class="text-5xl font-black text-gray-800 tracking-tighter uppercase italic mt-2">{{ $juego->titulo }}</h2>
                                </div>
                                <div class="text-right">
                                    <span class="block text-4xl font-black text-purple-600">⭐ {{ number_format($juego->notaMedia() ?? 0, 1) }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nota Media Global</span>
                                </div>
                            </div>

                            <p class="mt-8 text-gray-600 leading-relaxed text-lg italic">
                                "Domina los desafíos de <span class="font-bold text-gray-800">{{ $juego->titulo }}</span> y conviértete en una leyenda de la comunidad."
                            </p>

                            @php
                                $totalLogros = $juego->achievements->count();
                                $misLogrosIds = auth()->user()->achievements->pluck('id')->toArray();
                                $conseguidos = $juego->achievements->whereIn('id', $misLogrosIds)->count();
                                $porcentaje = $totalLogros > 0 ? round(($conseguidos / $totalLogros) * 100) : 0;
                            @endphp

                            <div class="mt-8 bg-white p-6 rounded-[2.5rem] border border-purple-100 shadow-sm relative overflow-hidden">
                                <div class="relative z-10">
                                    <div class="flex justify-between items-end mb-4">
                                        <div>
                                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-purple-500 block">Tu Nivel de Maestría</span>
                                            <span class="text-2xl font-black text-gray-800 italic uppercase">Estado: {{ $porcentaje == 100 ? 'Completado 🏆' : 'En Progreso 🎮' }}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-3xl font-black text-purple-600 tracking-tighter">{{ $porcentaje }}%</span>
                                            <p class="text-[9px] font-bold text-gray-400 uppercase">{{ $conseguidos }} de {{ $totalLogros }} trofeos</p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-5 p-1 shadow-inner border border-gray-50">
                                        <div class="bg-gradient-to-r from-purple-600 via-indigo-500 to-purple-400 h-full rounded-full transition-all duration-1000 relative" 
                                             style="width: <?php echo $porcentaje; ?>%;">
                                            <div class="absolute top-0 left-0 w-full h-full bg-white/20 rounded-full"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-data="{ openAchievements: false }" class="mt-10">
                            <div class="flex flex-wrap gap-4">
                                <button @click="openAchievements = !openAchievements" 
                                    class="flex items-center gap-3 bg-gray-900 hover:bg-black text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-lg active:scale-95">
                                    <span x-text="openAchievements ? '❌ Cerrar Logros' : '🏆 Ver Logros del Juego'"></span>
                                </button>
                                <a href="{{ route('videogames.catalogo') }}" class="flex items-center gap-3 bg-white border-2 border-gray-100 hover:border-purple-200 text-gray-600 px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-sm">
                                    ⬅️ Volver
                                </a>
                            </div>

                            <div x-show="openAchievements" x-transition class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                                @forelse($juego->achievements as $index => $logro)
                                    @php 
                                        $esMio = in_array($logro->id, $misLogrosIds);
                                        $colorClass = match(true) {
                                            $index + 1 <= 8 => 'from-orange-400 to-orange-700', // Bronce
                                            $index + 1 <= 14 => 'from-slate-300 to-slate-500',  // Plata
                                            $index + 1 <= 19 => 'from-yellow-300 to-yellow-600', // Oro
                                            default => 'from-indigo-400 to-purple-600 animate-pulse', // Platino
                                        };
                                        $bgBadge = $esMio ? 'bg-white' : 'bg-gray-200 grayscale opacity-40';
                                    @endphp

                                    <div class="relative flex items-center justify-between p-5 rounded-[2rem] border-2 transition-all duration-300 {{ $esMio ? 'bg-white border-purple-100 shadow-xl scale-[1.02]' : 'bg-gray-50 border-transparent opacity-75' }}">
                                        <div class="absolute -top-3 left-6 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-tighter text-white bg-gradient-to-r {{ $colorClass }}">
                                            {{ ($index + 1 <= 8) ? 'Bronce' : (($index + 1 <= 14) ? 'Plata' : (($index + 1 <= 19) ? 'Oro' : 'Platino')) }}
                                        </div>

                                        <div class="flex items-center gap-5">
                                            <div class="w-16 h-16 shrink-0 rounded-2xl p-1 bg-gradient-to-br {{ $colorClass }} shadow-lg">
                                                <div class="w-full h-full rounded-xl overflow-hidden {{ $bgBadge }} flex items-center justify-center">
                                                    <img src="{{ $logro->imagen_url }}" class="w-10 h-10 object-contain p-1">
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-black text-gray-800 text-sm uppercase tracking-tight">{{ $logro->nombre }}</h4>
                                                <p class="text-[10px] text-gray-500 font-bold leading-snug uppercase">{{ Str::limit($logro->descripcion, 45) }}</p>
                                            </div>
                                        </div>

                                        <form action="{{ route('achievements.toggle', $logro->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-3 rounded-2xl {{ $esMio ? 'bg-purple-600 text-white shadow-lg' : 'bg-white text-gray-300 border border-gray-100' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $esMio ? 'M5 13l4 4L19 7' : 'M12 4v16m8-8H4' }}" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-center col-span-full text-gray-400 font-black uppercase text-xs py-10">Sin logros.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="flex items-center gap-4 mb-8">
                    <h3 class="text-2xl font-black text-gray-800 italic uppercase tracking-tighter">Comunidad</h3>
                    <div class="h-[2px] flex-1 bg-gray-200"></div>
                </div>

                @auth
                <form action="{{ route('comments.store', $juego->id) }}" method="POST" class="mb-12 bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    @csrf
                    <textarea name="contenido" rows="3" class="w-full border-none bg-gray-50 rounded-2xl focus:ring-2 focus:ring-purple-500 p-4 font-bold" placeholder="¿Qué te parece este juego?"></textarea>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-black py-3 px-10 rounded-xl text-xs uppercase tracking-widest shadow-lg">Publicar</button>
                    </div>
                </form>
                @endauth

                <div class="space-y-6">
                    @forelse($juego->comments as $comment)
                    <div class="flex gap-6 p-6 bg-white rounded-[2rem] border border-gray-50 shadow-sm transition-all hover:shadow-md">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shrink-0 shadow-lg shadow-purple-100">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-black text-gray-800 uppercase text-xs tracking-wider">{{ $comment->user->name }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-600 leading-relaxed font-medium">{{ $comment->contenido }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-400 font-bold py-10">Sé el primero en comentar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>