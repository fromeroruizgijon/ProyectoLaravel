@extends('layouts.app')

@section('contenido')
    <h2>Editar nota</h2>

    <form action="{{ route('notas.update', $nota->id) }}" method="POST">
        @csrf
        @method('PUT') <div>
            <label for="titulo">Título de la nota:</label><br>
            <input type="text" name="titulo" id="titulo" value="{{ $nota->titulo }}" required>
        </div>
        <br>
        <div>
            <label for="contenido">Contenido:</label><br>
            <textarea name="contenido" id="contenido" rows="5" required>{{ $nota->contenido }}</textarea>
        </div>
        <br>
        <button type="submit">Actualizar Nota</button>
    </form>

    <br>
    <a href="{{ route('notas.index') }}">Cancelar y volver</a>
@endsection