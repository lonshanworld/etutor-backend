<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalTutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tutors')->insert([
            [
                'user_id' => 3,
                'qualifications' => 'PhD in Computer Science',
                'subject_id' => 3,
                'experience' => 5,
                'created_by' => 1
            ],
            [
                'user_id' => 4,
                'qualifications' => 'MSc in Mathematics',
                'subject_id' => 1,
                'experience' => 3,
                'created_by' => 1
            ],
            [
                'user_id' => 5,
                'qualifications' => 'MSc in Software Engineering',
                'subject_id' => 15,
                'experience' => 4,
                'created_by' => 1
            ],
            [
                'user_id' => 6,
                'qualifications' => 'MBA in Business',
                'subject_id' => 27,
                'experience' => 6,
                'created_by' => 1
            ]
        ]);
    }
}