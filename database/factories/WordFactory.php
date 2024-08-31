<?php

namespace Database\Factories;

use App\Models\Sound;
use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Word>
 */
class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'words' => [
                'لعب',
                'ركض',
                'لهو',
                'ورق',
                'سحاب',
                'رق',
                'نشر',
                'عقل',
            ],
            'sound_id' => Sound::all()->random(1)->first()->id,
            'training_id' => Training::all()->random(1)->first()->id,
        ];
    }
}
