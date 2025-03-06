<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'User',
            'email' => 'admin@gmail.com',
            'date_of_birth' => fake()->date(),
            'nationality' => 'MM',
            'gender_id' => 1,
            'role_id' => 1,
            'password' => Hash::make('password')
        ]);
    }
}
