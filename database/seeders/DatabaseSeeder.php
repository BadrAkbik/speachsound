<?php

namespace Database\Seeders;

use App\Models\AgeGroup;
use App\Models\Coupon;
use App\Models\Level;
use App\Models\Package;
use App\Models\Role;
use App\Models\Sound;
use App\Models\Subscription;
use App\Models\Test;
use App\Models\Trainee;
use App\Models\Training;
use App\Models\User;
use App\Models\Video;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Word;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $role_id = Role::firstOrCreate(['name' => 'owner'])->id;
        Role::firstOrCreate(['name' => 'user']);
        $user = User::where('email', 'admin@admin.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'admin',
                'phone_number' => '945496372',
                'email' => 'admin@admin.com',
                'role_id' => $role_id,
                'password' => 'admin123456',
            ]);
        }

        $users = User::factory(100)->create();
        Coupon::factory(10)->create();
        Package::factory(10)->create();
        Training::factory(20)->create();
        Trainee::factory(50)->create();
        Sound::factory(1)->create();
        Word::factory(2)->create();
        Test::factory(20)->create();

        $user->each(
            function (User $user) {
                $package_id = Package::all()->random(1)->first()->id;
                $user->subscription()->create(
                    [
                        'package_id' => $package_id,
                        'start_date' => '2024-07-01',
                        'end_date' => '2024-07-03',
                        'status' => 'active',
                        'renew' => false
                    ]
                );
            }
        );
        $package = Package::create([
            'name' => 'افتراضي',
            'price' => 1000,
            'patiant_count' => 10
        ]);
    }
}
