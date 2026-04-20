<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckGameOwner
{
    public function handle(Request $request, Closure $next)
    {
        // llega el id de la ruta
        $videojuegoId = $request->route('id');

        //buscamos mediante el id en la tabla pivot
        $videojuego = \App\Models\Videogame::find($videojuegoId);

        // si el juego existe, pero no está relacionado con el usuario lanza el error 403
        if ($videojuego && $videojuego->user_id !== Auth::id()) {
            abort(403, 'Acceso denegado: Este videojuego no te pertenece.');
        }
        // si todo está bien dejamos pasar a la petición
        return $next($request);
    }
}
