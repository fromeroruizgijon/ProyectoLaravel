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
        //crea un usuario de prueba
        $user = User::factory()->create([
            'name' => 'Usuario Prueba',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // crea 10 juegos con 20 logros
        $juegosGlobales = Game::factory(10)
            ->has(Achievement::factory()->count(20), 'achievements')
            ->create();

        // relaciona los juegos creados al usuario 
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
