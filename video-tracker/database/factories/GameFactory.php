<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'titulo' => $this->faker->unique()->sentence(3),
        'genero' => $this->faker->randomElement(['RPG', 'Acción', 'Aventura', 'Shooter']),
        'portada' => null, // Las imágenes del factory son complicadas, mejor dejarlas vacías
    ];
    }
}
