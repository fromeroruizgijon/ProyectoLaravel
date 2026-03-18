<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideogameController;
use App\Models\Videogame;
use Illuminate\Support\Facades\Auth;

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

    $ultimosJuegos = Videogame::latest()->take(5)->get();
    
    return view('dashboard', compact('ultimosJuegos', 'stats'));
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
});

require __DIR__.'/auth.php';
