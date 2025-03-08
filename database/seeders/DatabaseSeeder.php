<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();

        foreach (['admin', 'staff', 'student'] as $role) {
            Role::create(['name' => $role]);
        }

        User::factory()->create([
            'first_name' => 'User',
            'middle_name' => 'Mid',
            'last_name' => 'Last',
            'email' => 'admin@gmail.com',
            'date_of_birth' => fake()->date(),
            'nationality' => 'MM',
            'gender' => 'male',
            'role_id' => 1,
            'password' => Hash::make('password')
        ]);

        // Create 50 users with student role
        User::factory(50)->create(['role_id' => 3]);
    }
}
