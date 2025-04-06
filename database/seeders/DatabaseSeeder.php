<?php

namespace Database\Seeders;


use App\Models\AgeGroup;
use App\Models\User;
use App\Models\Age;
use App\Models\Sound;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@admin.com'], [
            'name' => 'admin',
            'phone_number' => '999999999',
            'password' => 'admin123456',
        ]);
        $ages = require_once base_path('data/default_ages.php');
        $sounds = require_once base_path('data/default_sounds.php');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AgeGroup::truncate();
        Age::truncate();
        Sound::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        AgeGroup::create([
            'name' => 'افتراضي',
            'from_age' => 0,
            'to_age' => 10,
        ]);
        Age::insert($ages);
        Sound::insert($sounds);

    }
}
