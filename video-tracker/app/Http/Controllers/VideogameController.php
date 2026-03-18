<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideogameController extends Controller
{
    public function index()
    {
        $videojuegos = Videogame::where('user_id', Auth::id())->get();
    
        return view('biblioteca', compact('videojuegos'));
    }
    // Muestra el formulario
    public function create()
    {
        return view('create');
    }

    // Guarda el juego en la DB
    public function store(Request $request)
    {
       // 1. Añadimos 'estado' a la validación
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'genero' => 'required|string|max:100',
        'plataforma' => 'required',
        'puntuacion_media' => 'required|numeric|min:0|max:10',
        'estado' => 'required', // <-- AÑADIDO
    ]);

    // 2. Añadimos 'estado' al crear el registro
    Videogame::create([
        'titulo'           => $validated['titulo'],
        'genero'           => $validated['genero'],
        'plataforma'       => $validated['plataforma'],
        'puntuacion_media' => $validated['puntuacion_media'],
        'estado'           => $validated['estado'], // <-- AÑADIDO
        'user_id'          => Auth::id(),
    ]);

    return redirect()->route('videogames.index')->with('success', '¡Juego añadido!');
    }
}
