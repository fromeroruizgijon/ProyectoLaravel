<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Game;
use App\Models\Videogame;
use App\Models\Achievement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos tu usuario de prueba
        $user = User::factory()->create([
            'name' => 'Usuario Prueba',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Creamos 10 juegos globales
        // Usamos 'has' para decirle: "Cada juego tiene 20 logros"
        $juegosGlobales = Game::factory(10)
            ->has(Achievement::factory()->count(20), 'achievements')
            ->create();

        // 3. Rellenamos la biblioteca personal del usuario
        // Vinculamos al usuario con esos juegos globales
        foreach ($juegosGlobales as $juego) {
            Videogame::create([
                'user_id' => $user->id,
                'game_id' => $juego->id,
                'plataforma' => collect(['PC', 'PS5', 'Xbox', 'Switch'])->random(),
                'puntuacion_personal' => rand(5, 10),
                'estado' => collect(['Jugando', 'Completado', 'Pendiente'])->random(),
            ]);
        }
    }
}
