@extends('layouts.app') @section('contenido')   <h2>Listado de notas</h2>

    <a href="{{ route('notas.create') }}">Crear nueva nota</a>

    <ul>
        @foreach($notas as $nota)
            <li>
                <strong>{{ $nota->titulo }}</strong>: {{ $nota->contenido }}
                
                <a href="{{ route('notas.edit', $nota->id) }}">[Editar]</a>

                <form action="{{ route('notas.destroy', $nota->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Seguro que quieres borrarla?')">Borrar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection