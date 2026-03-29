<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Cambiamos $gameId por $game para que coincida con la ruta {game}
    public function store(Request $request, $game)
    {
        $request->validate([
            'contenido' => 'required|min:3|max:500',
        ]);

        // Usamos Auth::id() que es el estándar de Laravel
        Comment::create([
            'user_id'   => Auth::id(), 
            'game_id'   => $game, 
            'contenido' => $request->contenido,
        ]);

        return back()->with('success', '¡Comentario publicado!');
    }
}
