<?php

namespace Database\Factories;

use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_en' => fake()->unique()->name(),
            'success_attempts' => fake()->numberBetween(10,20),
            'success_rate' => fake()->numberBetween(10,20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
