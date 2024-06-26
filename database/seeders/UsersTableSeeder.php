<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'nickname' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
