<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;
use App\Models\Achievement;

class VideogameController extends Controller
{
    public function index()
    {
        $videojuegos = Videogame::with('game')->where('user_id', Auth::id())->get();
        return view('biblioteca', compact('videojuegos'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'genero' => 'required|string',
            'plataforma' => 'required',
            'puntuacion_personal' => 'required|numeric|min:0|max:10',
            'estado' => 'required',
            'portada' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. Buscamos el juego limpiando espacios extra
        $tituloLimpio = trim($validated['titulo']);

        $game = Game::firstOrCreate(
            ['titulo' => $tituloLimpio],
            ['genero' => $validated['genero']]
        );

        // 2. Si se sube una foto, la guardamos
        if ($request->hasFile('portada')) {
            $path = $request->file('portada')->store('portadas', 'public');
            // Actualizamos la carátula global del juego
            $game->update(['portada' => $path]);
        }

        // 3. Guardamos o actualizamos en la biblioteca personal
        Videogame::updateOrCreate(
            ['user_id' => Auth::id(), 'game_id' => $game->id],
            [
                'plataforma' => $validated['plataforma'],
                'puntuacion_personal' => $validated['puntuacion_personal'],
                'estado' => $validated['estado'],
            ]
        );

        return redirect()->route('videogames.index')->with('success', '¡Juego gestionado correctamente!');
    }

    public function catalogo(Request $request)
    {
        // 1. Recogemos ambos posibles filtros de la URL
        $buscar = $request->input('search');
        $genero = $request->input('genero');

        $juegosGlobales = Game::query() // Empezamos una consulta limpia
            // 2. Si hay texto en el buscador, filtramos por título
            ->when($buscar, function ($query) use ($buscar) {
                return $query->where('titulo', 'LIKE', "%{$buscar}%");
            })
            // 3. Si se ha seleccionado un género, filtramos por género
            ->when($genero, function ($query) use ($genero) {
                return $query->where('genero', $genero);
            })
            // 4. Paginamos los resultados (manteniendo los filtros en los enlaces)
            ->paginate(6)
            ->withQueryString(); 

        return view('catalogo', compact('juegosGlobales'));
    }

    public function votar(Request $request, $game_id)
    {
        $validated = $request->validate([
            'puntuacion_personal' => 'required|numeric|min:0|max:10',
            'estado' => 'required'
        ]);

        Videogame::updateOrCreate(
            ['user_id' => Auth::id(), 'game_id' => $game_id],
            [
                'puntuacion_personal' => $validated['puntuacion_personal'],
                'estado' => $validated['estado'],
                'plataforma' => 'PC' 
            ]
        );

        return back()->with('success', '¡Voto registrado en tu biblioteca!');
    }

    // Muestra el formulario de edición
    public function edit($id)
    {
        $videojuego = Videogame::with('game')->where('user_id', Auth::id())->findOrFail($id);
        return view('edit', compact('videojuego'));
    }

    // Procesa la actualización
    public function update(Request $request, $id)
    {
        $videojuego = Videogame::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'puntuacion_personal' => 'required|numeric|min:0|max:10',
            'estado' => 'required',
            'plataforma' => 'required'
        ]);

        $videojuego->update($validated);

        return redirect()->route('videogames.index')->with('success', '¡Juego actualizado!');
    }

    // Borra el juego de TU colección
    public function destroy($id)
    {
        $videojuego = Videogame::where('user_id', Auth::id())->findOrFail($id);
        $videojuego->delete();

        return back()->with('success', 'Juego eliminado de tu biblioteca');
    }
    public function show($id)
    {
       // 1. Cargamos el juego con sus comentarios y logros existentes
        $juego = Game::with(['comments.user', 'achievements'])->findOrFail($id);

        // 2. Si el juego no tiene logros en nuestra BD, intentamos buscarlos fuera
        if ($juego->achievements->isEmpty()) {
            try {
                $token = $this->getIgdbToken();

                if ($token) {
                    // Buscamos el ID del juego en IGDB (limpiamos el título por si acaso)
                    $termino = trim($juego->titulo);
                    
                    $searchResponse = Http::withHeaders([
                        'Client-ID' => config('services.igdb.client_id'),
                        'Authorization' => 'Bearer ' . $token,
                    ])->withBody("search \"{$termino}\"; fields id; limit 1;", 'text/plain')
                    ->post('https://api.igdb.com/v4/games');

                    $searchData = $searchResponse->json();
                    $igdbGameId = $searchData[0]['id'] ?? null;

                    // Si encontramos el juego, pedimos sus logros
                    if ($igdbGameId) {
                        $achievementsResponse = Http::withHeaders([
                            'Client-ID' => config('services.igdb.client_id'),
                            'Authorization' => 'Bearer ' . $token,
                        ])->withBody("fields name,description,locked_achievement_icon; where game = {$igdbGameId};", 'text/plain')
                        ->post('https://api.igdb.com/v4/achievements');

                        $externalAchievements = $achievementsResponse->json();

                        // VALIDACIÓN CLAVE: Solo recorremos si es un array con datos
                        if (is_array($externalAchievements) && count($externalAchievements) > 0) {
                            foreach ($externalAchievements as $extAcc) {
                                Achievement::create([
                                    'game_id'   => $juego->id,
                                    'nombre'    => $extAcc['name'] ?? 'Logro oculto',
                                    'descripcion'=> $extAcc['description'] ?? 'Sin descripción disponible',
                                    'imagen_url'=> $extAcc['locked_achievement_icon'] ?? null,
                                ]);
                            }
                            // Recargamos la relación ahora que hay datos nuevos
                            $juego->load('achievements');
                        }
                    }
                }
            } catch (\Exception $e) {
                // Si algo falla (internet, API caída...), no hacemos nada. 
                // La página cargará pero con la lista de logros vacía.
                logger("Error buscando logros: " . $e->getMessage());
            }
        }

        return view('show', compact('juego'));
    }
    private function getIgdbToken()
    {
        $response = Http::post('https://id.twitch.tv/oauth2/token', [
            'client_id' => config('services.igdb.client_id'),
            'client_secret' => config('services.igdb.client_secret'),
            'grant_type' => 'client_credentials',
        ]);

        return $response->json()['access_token'] ?? null;
    }
    public function toggleAchievement(Achievement $achievement)
    {
        $user = Auth::user();
        // Usamos la fachada Auth que ya tienes importada arriba
        $user()->achievements()->toggle($achievement->id);
        
        return back();
    }
}
