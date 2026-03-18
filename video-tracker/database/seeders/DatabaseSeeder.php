<?php

namespace Database\Seeders;
use App\Models\Videogame;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creamos un usuario de prueba
    $user = User::factory()->create([
        'name' => 'Usuario Prueba',
        'email' => 'test@example.com',
    ]);

    // 2. Creamos los 20 videojuegos asignándoselos a ese usuario
    Videogame::factory(20)->create([
        'user_id' => $user->id,
    ]);
    }
}
