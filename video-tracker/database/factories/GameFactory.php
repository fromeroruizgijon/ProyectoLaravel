<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->unique()->words(3, true),
            'genero' => $this->faker->randomElement(['RPG', 'Acción', 'Aventura', 'Shooter', 'Terror', 'Indie']),
            'portada_url' => 'https://placehold.co/600x800?text=Game+Cover',
            'igdb_id' => $this->faker->unique()->numberBetween(100, 999999),
        ];
    }
}
