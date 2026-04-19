<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideogameController;
use App\Models\Videogame;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;

// rutas públicas
Route::get('/', function () {
    return view('auth.login');
});

// Middleware
Route::middleware(['auth'])->group(function () {

   //dashboard 
    Route::get('/dashboard', function () {
        $user_id = Auth::id();
        $stats = [
            'total' => Videogame::where('user_id', $user_id)->count(),
            'jugando' => Videogame::where('user_id', $user_id)->where('estado', 'Jugando')->count(),
            'completados' => Videogame::where('user_id', $user_id)->where('estado', 'Completado')->count(),
        ];
        $ultimosJuegosGlobales = Game::latest()->take(5)->get();
        return view('dashboard', compact('ultimosJuegosGlobales', 'stats'));
    })->name('dashboard');

    //biblioteca y catálogo
    Route::get('/biblioteca', [VideogameController::class, 'index'])->name('videogames.index');
    Route::get('/catalogo', [VideogameController::class, 'catalogo'])->name('videogames.catalogo');
    Route::post('/votar/{game_id}', [VideogameController::class, 'votar'])->name('videogames.votar');

    //creación de juegos
    Route::get('/videojuegos/crear', [VideogameController::class, 'create'])->name('videogames.create');
    Route::post('/videojuegos', [VideogameController::class, 'store'])->name('videogames.store');
    Route::get('/api/search-igdb', [VideogameController::class, 'searchIgdb'])->name('api.search.igdb');

    //vista detalle y comentarios
    Route::get('/juegos/{id}', [VideogameController::class, 'show'])->name('games.show');
    Route::post('/games/{game}/comments', [CommentController::class, 'store'])->name('comments.store');
    //logros
    Route::post('/achievements/{id}/toggle', [VideogameController::class, 'toggleAchievement'])->name('achievements.toggle');

    //rutas de perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //middlwware, solo se puede editar un juego si te pertenece
    Route::middleware(['game.owner'])->group(function () {
        //edición
        Route::get('/videojuegos/{id}/editar', [VideogameController::class, 'edit'])->name('videogames.edit');
        Route::put('/videojuegos/{id}', [VideogameController::class, 'update'])->name('videogames.update');
        //eliminación
        Route::delete('/videojuegos/{id}', [VideogameController::class, 'destroy'])->name('videogames.destroy');
    });

});
require __DIR__.'/auth.php';