<?php

namespace Database\Seeders;

use App\Models\AgeGroup;
use App\Models\Coupon;
use App\Models\Level;
use App\Models\Package;
use App\Models\Role;
use App\Models\Subscribtion;
use App\Models\Test;
use App\Models\Trainee;
use App\Models\Training;
use App\Models\User;
use App\Models\Video;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        AgeGroup::factory(5)->create();
        Coupon::factory(10)->create();
        Level::factory(5)->create();
        Package::factory(10)->create();
        Test::factory(20)->create();
        Training::factory(20)->create();
        Trainee::factory(50)->create();
        Video::factory(20)->create();

        $user->each(
            function (User $user) {
                $package_id = Package::all()->random(1)->first()->id;
                $user->packages()->syncWithPivotValues(
                    [$package_id],  // Use the package ID
                    [
                        'start_date' => '2024-07-01',
                        'end_date' => '2024-07-03',
                        'status' => 'active',
                        'renew' => false
                    ]
                );
            }
        );
        $package = Package::create([
            'name_ar' => 'افتراضي',
            'name_en' => 'default',
            'price' => 1000,
            'patiant_count' => 10
        ]);

        $user->packages()->syncWithPivotValues(
            [$package->id],
            [
                'start_date' => '2024-07-01',
                'end_date' => '2024-07-03',
                'status' => 'active',
                'renew' => false,
            ]
        );
    }
}
