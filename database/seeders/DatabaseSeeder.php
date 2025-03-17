<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Role;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles creation
        foreach (['admin', 'tutor', 'student'] as $role) {
            Role::create(['name' => $role]);
        }
        // create 10 user for each role
        foreach (Role::cursor() as $key => $role) {
            for ($i = 1; $i < 7; $i++) {
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

        // Call the Subject and Major Seeder
        $this->call(SubjectSeeder::class);
        $this->call(MajorSeeder::class);

        // Assign subjects to majors
        $this->call(MajorSubjectSeeder::class);
    }
}
