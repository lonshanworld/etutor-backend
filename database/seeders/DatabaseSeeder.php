<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Role;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Middleware\Authorize;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();

        foreach (['admin', 'tutor', 'student'] as $role) {
            Role::create(['name' => $role]);
        }

        User::factory()->create(['role_id' => 1, 'email' => 'admin@gmail.com']);


        // create 10 user for each role
        foreach (Role::cursor() as $key => $role) {
            for ($i = 1; $i < 11; $i++) {
                User::factory()->create([
                    'first_name' => fake()->firstName(),
                    'middle_name' => 'Mid',
                    'last_name' => fake()->lastName(),
                    'email' => $role->name . $i . '@gmail.com',
                    'date_of_birth' => fake()->date(),
                    'nationality' => 'MM',
                    'gender' => fake()->randomElement(['male', 'female']),
                    'role_id' => $role->id,
                    'password' => Hash::make('password')
                ]);
            }
        }

        // create major dummy data
        // Major::factory(10)->has(
        //     Subject::factory()->count(3)
        // )
        // ->create([
        //     'education_year' => Carbon::now()->year
        // ]);
    }
}
