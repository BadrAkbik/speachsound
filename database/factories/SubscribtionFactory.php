<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscribtion>
 */
class SubscribtionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'package_id' => Package::all()->random(1)->first()->id,
            'user_id' => User::all()->random(1)->first()->id,
            'start_date' => fake()->dateTimeBetween(now()->subMonths(3), now()->addYear()),
            'end_date' => fake()->dateTimeBetween(now(), now()->addYear()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
