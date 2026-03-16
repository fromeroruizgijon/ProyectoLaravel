<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Biblioteca de Videojuegos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Género</th>
                            <th>Plataforma</th>
                            <th>Puntuación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($videojuegos as $juego)
                            <tr>
                                <td>{{ $juego->titulo }}</td>
                                <td>{{ $juego->genero }}</td>
                                <td>{{ $juego->plataforma }}</td>
                                <td>{{ $juego->puntuacion_media }}/10</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>