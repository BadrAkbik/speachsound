<?php

namespace Database\Factories;

use App\Models\Sound;
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
            'type' => 'natural',
            'video' => fake()->image(),
            'sound_id' => Sound::all()->random(1)->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
