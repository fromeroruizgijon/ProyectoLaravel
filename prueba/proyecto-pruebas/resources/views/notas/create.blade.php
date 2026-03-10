@extends('layouts.app')

@section('contenido')
    <h2>Crear una nueva nota</h2>

    <form action="{{ route('notas.store') }}" method="POST">
        @csrf

        <div>
            <label for="titulo">Título de la nota:</label><br>
            <input type="text" name="titulo" id="titulo" required>
        </div>
        <br>
        <div>
            <label for="contenido">Contenido:</label><br>
            <textarea name="contenido" id="contenido" rows="5" required></textarea>
        </div>
        <br>
        <button type="submit">Guardar Nota</button>
    </form>

    <br>
    <a href="{{ route('notas.index') }}">Volver a la lista</a>
@endsection