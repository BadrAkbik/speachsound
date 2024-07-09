<?php

namespace Database\Factories;

use App\Models\Test;
use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'normal',
            'path' => fake()->image(),
            'related_type' => fake()->randomElement(['test', 'training']),
            'related_id' => fake()->randomElement([Test::all()->random(1)->first()->id, Training::all()->random(1)->first()->id]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
