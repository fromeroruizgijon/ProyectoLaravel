<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideogameController;
use App\Models\Videogame;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    // Cogemos los últimos 5 videojuegos creados
    $ultimosJuegos = Videogame::latest()->take(5)->get();
    
    // Pasamos los datos a la vista
    return view('dashboard', compact('ultimosJuegos'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/biblioteca', [VideogameController::class, 'index'])->name('videogames.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
