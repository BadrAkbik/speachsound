<?php

namespace Database\Factories;

use App\Models\AgeGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Levels>
 */
class LevelFactory extends Factory
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
            'age_group_id' => AgeGroup::all()->random(1)->first()->id,
            'success_rate' => fake()->numberBetween(40, 75),
            'attemtps_count' => fake()->numberBetween(10,20),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
