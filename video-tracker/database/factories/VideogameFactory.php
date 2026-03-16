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
        return [
            'titulo' => $this->faker->sentence(3),
            'genero' => $this->faker->randomElement(['Accion', 'RPG', 'Aventura', 'Deportes']),
            'plataforma' => $this->faker->randomElement(['PC', 'PS5', 'Xbox', 'Switch']),
            'resumen' => $this->faker->paragraph(),
            'puntuacion_media' => $this->faker->numberBetween(1, 10),
        ];
    }
}
