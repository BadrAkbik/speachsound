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
            'level_id' => Level::all()->random(1)->first()->id,
            'images' => fake()->image(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
