<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[3rem] shadow-xl overflow-hidden border border-gray-100 mb-12">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 bg-gray-100">
                        @if($juego->portada_url)
                            <img src="{{ $juego->portada_url }}" class="w-full h-full object-cover shadow-2xl">
                        @elseif($juego->portada)
                            <img src="{{ asset('storage/' . $juego->portada) }}" class="w-full h-full object-cover shadow-2xl">
                        @else
                            <div class="flex items-center justify-center h-96 text-gray-400 font-black uppercase italic text-center px-4">
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
                                    <span class="block text-4xl font-black text-purple-600">⭐ {{ number_format($juego->notaMedia(), 1) }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nota Media Global</span>
                                </div>
                            </div>

                            <p class="mt-8 text-gray-600 leading-relaxed text-lg">
                                Bienvenido a la ficha oficial de <span class="font-bold text-gray-800">{{ $juego->titulo }}</span>. Explora los logros, comparte tu opinión con otros jugadores y gestiona tu progreso personal.
                            </p>

                            @php
                                $totalLogros = $juego->achievements->count();
                                $misLogrosIds = auth()->user()->achievements->pluck('id')->toArray();
                                $conseguidos = $juego->achievements->whereIn('id', $misLogrosIds)->count();
                                $porcentaje = $totalLogros > 0 ? round(($conseguidos / $totalLogros) * 100) : 0;
                            @endphp

                            <div class="mt-8 bg-gray-50 p-4 rounded-3xl border border-gray-100">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-black uppercase tracking-widest text-purple-600 italic">Progreso de Trofeos</span>
                                    <span class="text-xs font-black text-gray-800">{{ $conseguidos }} / {{ $totalLogros }} ({{ $porcentaje }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-full transition-all duration-500" 
                                         style="width: <?php echo $porcentaje; ?>%;">
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
                                    ⬅️ Volver al Catálogo
                                </a>
                            </div>

                            <div x-show="openAchievements" x-transition class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($juego->achievements as $logro)
                                    @php $esMio = in_array($logro->id, $misLogrosIds); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-3xl border-2 transition-all {{ $esMio ? 'bg-purple-50 border-purple-200 shadow-sm' : 'bg-white border-transparent' }}">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 shrink-0 rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center border border-gray-50">
                                                @if($logro->imagen_url)
                                                    <img src="{{ $logro->imagen_url }}" class="w-full h-full object-cover {{ $esMio ? '' : 'grayscale opacity-50' }}">
                                                @else
                                                    <span class="text-xl">🏆</span>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-black text-gray-800 text-[10px] uppercase tracking-tighter">{{ $logro->nombre }}</h4>
                                                <p class="text-[9px] text-gray-400 font-bold leading-tight uppercase">{{ Str::limit($logro->descripcion, 40) }}</p>
                                            </div>
                                        </div>

                                        <form action="{{ route('achievements.toggle', $logro->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 rounded-xl transition-all {{ $esMio ? 'bg-purple-600 text-white shadow-md' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $esMio ? 'M5 13l4 4L19 7' : 'M12 4v16m8-8H4' }}" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="col-span-full py-10 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 text-center">
                                        <p class="text-gray-400 font-black uppercase tracking-widest text-xs italic">
                                            No hay logros disponibles para este título.
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="flex items-center gap-4 mb-8">
                    <h3 class="text-2xl font-black text-gray-800 italic uppercase tracking-tighter">
                        Opiniones de la <span class="text-purple-600">Comunidad</span>
                    </h3>
                    <div class="h-[2px] flex-1 bg-gray-100"></div>
                </div>

                @auth
                <form action="{{ route('comments.store', $juego->id) }}" method="POST" class="mb-12 bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    @csrf
                    <textarea name="contenido" rows="3" 
                        class="w-full border-none bg-gray-50 rounded-2xl focus:ring-2 focus:ring-purple-500 placeholder:text-gray-400 transition-all p-4 font-bold"
                        placeholder="Escribe tu reseña o comentario aquí..."></textarea>
                    
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-black py-3 px-10 rounded-xl shadow-lg shadow-purple-100 transition transform active:scale-95 text-xs uppercase tracking-widest">
                            Publicar Comentario
                        </button>
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
                            <p class="text-gray-600 leading-relaxed font-medium">
                                {{ $comment->contenido }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm italic">Aún no hay opiniones. ¡Sé el primero!</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>