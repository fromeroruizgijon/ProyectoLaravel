<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Game;
use App\Models\Videogame;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos tu usuario de prueba
        $user = User::factory()->create([
            'name' => 'Usuario Prueba',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Para que puedas entrar
        ]);

        // 2. Creamos 10 juegos genéricos en la enciclopedia global (sin dueño)
        // Esto rellena la tabla 'games'
        $juegosGlobales = Game::factory(10)->create();

        // 3. Creamos 20 registros en la biblioteca personal del usuario
        // Cada uno de estos 20 registros elegirá uno de los 10 juegos globales
        Videogame::factory(20)->create([
            'user_id' => $user->id,
            'game_id' => function () use ($juegosGlobales) {
                return $juegosGlobales->random()->id;
            },
        ]);
    }
}
