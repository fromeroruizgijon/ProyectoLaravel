<?php

namespace Database\Factories;

use App\Models\Videogame;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Videogame>
 */
class VideogameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
        {
            // 1. Primero nos aseguramos de que haya un "Game" global
            $game = \App\Models\Game::inRandomOrder()->first() ?? \App\Models\Game::factory()->create();

            return [
                'user_id' => \App\Models\User::all()->random()->id ?? \App\Models\User::factory(),
                'game_id' => $game->id, // <--- La clave es esta relación
                'plataforma' => $this->faker->randomElement(['PC', 'PS5', 'Xbox', 'Switch']),
                'puntuacion_personal' => $this->faker->randomFloat(1, 0, 10),
                'estado' => $this->faker->randomElement(['Pendiente', 'Jugando', 'Completado', 'Abandonado']),
            ];
        }
}
