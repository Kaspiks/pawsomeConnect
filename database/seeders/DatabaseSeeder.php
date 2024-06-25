<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ServiceCategory;
use App\Models\Service;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $userRole = Role::create(['name' => 'User']);
        $adminRole = Role::create(['name' => 'Admin']);

        $user = User::factory()->create([
            'nickname' => 'Kaspars',
            'email' => 'kaspars@gmail.com',
            'password' => 'kaspiks12'
        ]);

        $user2 = User::factory()->create([
            'nickname' => 'Kaspars2',
            'email' => 'kaspiks@edu.lu.lv',
            'password' => 'kaspiks12'
        ]);

        $user->assignRole($userRole);
        $user2->assignRole($adminRole);

        $serviceCategories = [
            'Pet Grooming', 'Dog Walking', 'Pet Sitting', 'Veterinary Care', 'Pet Training',
            'Pet Boarding', 'Pet Taxi', 'Pet Photography', 'Pet Nutrition Consultation',
            'Pet Massage/Therapy', 'Pet Waste Removal', 'Pet Daycare', 'Pet Adoption Services',
            'Exotic Pet Care', 'Pet Memorial Services'
        ];

        foreach ($serviceCategories as $categoryName) {
            ServiceCategory::factory()->create(['name' => $categoryName]);
        }

        Service::factory()->count(10)->create()->each(function ($service) use ($user, $user2) {
            $owner = rand(0, 1) ? $user : $user2;
            $service->users()->attach($owner, ['user_type' => 'owner']);
        });
    }
}
