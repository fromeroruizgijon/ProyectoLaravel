<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Buscamos el juego con sus relaciones
        $juego = Game::with(['videogames.user', 'comments.user'])->findOrFail($id);
        
        return view('show', compact('juego'));
    }
}
