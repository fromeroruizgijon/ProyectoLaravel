<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController; // Importamos tu controlador

// Esta única línea crea las 7 rutas necesarias para un CRUD (con sus nombres y parámetros)
Route::resource('notas', NotaController::class);

// Ruta por defecto para que al entrar a la raíz te lleve a las notas
Route::get('/', function () {
    return redirect()->route('notas.index');
});
