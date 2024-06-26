<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\PetType;
use App\Models\User;

class PetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PetType = [
            'Dog',
            'Cat',
            'Hampster',
            'Bunny',
            'Fish',
            'Turtle',
        ];


        
        $user = User::role('User')->get()->first();
        $user_adm= User::role('Admin')->get()->first();

        foreach ($PetType as $Type) {
            PetType::factory()->create(['name' => $Type]);
        }

        Pet::factory()->count(10)->create();

        Pet::factory()->count(10)->create()->each(function ($pet) use ($user, $user_adm) {
            $owner = rand(0, 1) ? $user : $user_adm;
            $pet->users()->attach($owner);
        });
    }
}
