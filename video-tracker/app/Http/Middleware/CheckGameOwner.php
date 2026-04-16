<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckGameOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Obtenemos el ID del videojuego de la ruta (URL)
        // El nombre 'id' debe coincidir con el que usas en routes/web.php {id}
        $videojuegoId = $request->route('id');

        // 2. Buscamos el registro en la tabla pivot 'videogames'
        $videojuego = \App\Models\Videogame::find($videojuegoId);

        // 3. Si el juego existe pero NO pertenece al usuario logueado...
        if ($videojuego && $videojuego->user_id !== Auth::id()) {
            // ...le lanzamos un error 403 (Prohibido)
            abort(403, 'Acceso denegado: Este videojuego no te pertenece.');
        }

        // 4. Si todo está bien, dejamos que la petición siga su curso
        return $next($request);
    }
}
