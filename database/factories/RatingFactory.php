<?php

namespace Database\Factories;

use App\Models\Trainee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trainee_id' => Trainee::all()->random(1)->first()->id,
            'degree' => fake()->numberBetween(0,10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
