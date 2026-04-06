<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use App\Models\Game;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
            'titulo' => 'required|string',
            'genero' => 'required|string',
            'plataforma' => 'required',
            'puntuacion_personal' => 'required|numeric|min:0|max:10',
            'estado' => 'required',
            'portada' => 'nullable|image|max:2048',
            'portada_url' => 'nullable|string',
            'igdb_id' => 'nullable|integer',
        ]);

        $game = Game::firstOrCreate(
            ['titulo' => $validated['titulo']],
            [
                'genero' => $validated['genero'],
                'portada_url' => $request->portada_url,
                'igdb_id' => $request->igdb_id
            ]
        );

        if ($request->hasFile('portada')) {
            $path = $request->file('portada')->store('portadas', 'public');
            $game->update(['portada' => $path]);
        }

        Videogame::updateOrCreate(
            ['user_id' => Auth::id(), 'game_id' => $game->id],
            [
                'plataforma' => $validated['plataforma'],
                'puntuacion_personal' => $validated['puntuacion_personal'],
                'estado' => $validated['estado'],
            ]
        );

        return redirect()->route('videogames.index')->with('success', '¡Juego añadido!');
    }

    public function catalogo(Request $request)
    {
        $buscar = $request->input('search');
        $genero = $request->input('genero');

        $juegosGlobales = Game::query()
            ->when($buscar, function ($query) use ($buscar) {
                return $query->where('titulo', 'LIKE', "%{$buscar}%");
            })
            ->when($genero, function ($query) use ($genero) {
                return $query->where('genero', $genero);
            })
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

    public function edit($id)
    {
        $videojuego = Videogame::with('game')->where('user_id', Auth::id())->findOrFail($id);
        return view('edit', compact('videojuego'));
    }

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

    public function destroy($id)
    {
        $videojuego = Videogame::where('user_id', Auth::id())->findOrFail($id);
        $videojuego->delete();
        return back()->with('success', 'Juego eliminado de tu biblioteca');
    }

    public function show($id)
    {
        $juego = Game::with(['comments.user', 'achievements'])->findOrFail($id);

        // Sistema de 20 Logros Automáticos
        if ($juego->achievements->isEmpty()) {
            $tipos = ['Bronce', 'Plata', 'Oro', 'Platino'];
            
            for ($i = 1; $i <= 20; $i++) {
                // Determinamos la dificultad/tipo según el número
                $tipo = $tipos[($i - 1) % 4]; 
                
                // Nombres dinámicos para que no sean todos iguales
                $nombre = match(true) {
                    $i === 1  => "Bienvenido a " . $juego->titulo,
                    $i === 10 => "Mitad del Camino",
                    $i === 20 => "Leyenda de " . $juego->titulo,
                    $i % 5 === 0 => "Desafío Especial Nivel " . ($i / 5),
                    default => "Logro de " . $tipo . " #" . $i
                };

                Achievement::create([
                    'game_id'     => $juego->id,
                    'nombre'      => $nombre,
                    'descripcion' => "Has desbloqueado el desafío número {$i} en la categoría {$tipo}.",
                    'imagen_url'  => 'https://cdn-icons-png.flaticon.com/512/3112/3112946.png',
                ]);
            }
            // Recargamos la relación para que el conteo en el Blade sea 20
            $juego = $juego->fresh('achievements');
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

    public function toggleAchievement($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user) {
            $user->achievements()->toggle($id);
        }

        return back();
    }

    public function searchIgdb(Request $request)
    {
        $search = $request->query('q');
        $token = $this->getIgdbToken();

        if (!$token || strlen($search) < 3) return response()->json([]);

        $response = Http::withHeaders([
            'Client-ID' => config('services.igdb.client_id'),
            'Authorization' => 'Bearer ' . $token,
        ])->withBody("search \"{$search}\"; fields name, cover.url, genres.name, id; limit 5;", 'text/plain')
        ->post('https://api.igdb.com/v4/games');

        $games = collect($response->json())->map(function($game) {
            return [
                'name' => $game['name'],
                'id' => $game['id'],
                'cover' => isset($game['cover']['url']) 
                    ? str_replace('t_thumb', 't_cover_big', "https:" . $game['cover']['url']) 
                    : null,
                'genre' => $game['genres'][0]['name'] ?? 'Otros'
            ];
        });

        return response()->json($games);
    }
}