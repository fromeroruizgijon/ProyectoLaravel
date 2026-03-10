<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    // 1. Obtenemos todas las notas de la base de datos usando Eloquent ORM
    $notas = Nota::all(); 

    // 2. Devolvemos una vista llamada 'index' dentro de la carpeta 'notas' y le pasamos los datos
    return view('notas.index', compact('notas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('notas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      // 1. Creamos una nueva "Nota" vacía
    $nota = new Nota();

    // 2. Rellenamos sus propiedades con lo que viene del formulario
    $nota->titulo = $request->titulo;
    $nota->contenido = $request->contenido;

    // 3. Guardamos en la base de datos
    $nota->save();

    // 4. Redirigimos al usuario de vuelta a la lista principal
    return redirect()->route('notas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nota $nota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nota $nota)
    {
        return view('notas.edit', compact('nota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nota $nota)
    {
        $nota->titulo = $request->titulo;
        $nota->contenido = $request->contenido;
        $nota->save();

        return redirect()->route('notas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect()->route('notas.index');
    }
}
