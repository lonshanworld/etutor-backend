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
        //Call all the seeders
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            SubjectSeeder::class,
            MajorSeeder::class,
            MajorSubjectSeeder::class,
            AuthorisedStaffSeeder::class,
            PersonalTutorSeeder::class,
            StudentSeeder::class
        ]);
        // create 10 user for each role
        // foreach (Role::cursor() as $key => $role) {
        //     for ($i = 1; $i < 7; $i++) {
        //         User::factory()->create([
        //             'first_name' => fake()->firstName(),
        //             'middle_name' => 'Mid',
        //             'last_name' => fake()->lastName(),
        //             'email' => $role->name . $i . '@gmail.com',
        //             'date_of_birth' => fake()->date(),
        //             'nationality' => 'MM',
        //             'gender' => fake()->randomElement(['male', 'female']),
        //             'role_id' => $role->id,
        //             'password' => Hash::make('password')
        //         ]);
        //     }
        // }
    }
}
