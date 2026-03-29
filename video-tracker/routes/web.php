<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideogameController;
use App\Models\Videogame;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $user_id = Auth::id();
    
    $stats = [
        'total' => Videogame::where('user_id', $user_id)->count(),
        'jugando' => Videogame::where('user_id', $user_id)->where('estado', 'Jugando')->count(),
        'completados' => Videogame::where('user_id', $user_id)->where('estado', 'Completado')->count(),
    ];

    $ultimosJuegosGlobales = Game::latest()->take(5)->get();
    
    return view('dashboard', compact('ultimosJuegosGlobales', 'stats'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //ruta a biblioteca
    Route::get('/biblioteca', [VideogameController::class, 'index'])->name('videogames.index');
    //rutas de formulario
    Route::get('/videojuegos/crear', [VideogameController::class, 'create'])->name('videogames.create');
    Route::post('/videojuegos', [VideogameController::class, 'store'])->name('videogames.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/catalogo', [VideogameController::class, 'catalogo'])->name('videogames.catalogo');
    Route::post('/votar/{game_id}', [VideogameController::class, 'votar'])->name('videogames.votar');

    // Editar: El formulario y el proceso
    Route::get('/videojuegos/{id}/editar', [VideogameController::class, 'edit'])->name('videogames.edit');
    Route::put('/videojuegos/{id}', [VideogameController::class, 'update'])->name('videogames.update');

    // Borrar
    Route::delete('/videojuegos/{id}', [VideogameController::class, 'destroy'])->name('videogames.destroy');

    // Detalle del juego (Público/Autenticado)
    Route::get('/juegos/{id}', [VideogameController::class, 'show'])->name('games.show');

    Route::post('/games/{game}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
});

require __DIR__.'/auth.php';
