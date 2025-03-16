<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            ['major_name' => 'Computer Science', 'education_year' => 4],
            ['major_name' => 'Information Technology', 'education_year' => 4],
            ['major_name' => 'Software Engineering', 'education_year' => 4],
            ['major_name' => 'Data Science', 'education_year' => 4],
            ['major_name' => 'Cybersecurity', 'education_year' => 4],
            ['major_name' => 'Business Administration', 'education_year' => 4],
            ['major_name' => 'Accounting and Finance', 'education_year' => 3],
            ['major_name' => 'Marketing', 'education_year' => 3],
            ['major_name' => 'Mechanical Engineering', 'education_year' => 4],
            ['major_name' => 'Graphic Design', 'education_year' => 3],
            ['major_name' => 'Psychology', 'education_year' => 4],
            ['major_name' => 'Law', 'education_year' => 4],
            ['major_name' => 'Education', 'education_year' => 4],
            ['major_name' => 'Environmental Science', 'education_year' => 4],
        ];

        foreach ($majors as $major) {
            DB::table('majors')->insert([
                'name' => $major['major_name'],
                'education_year' => $major['education_year'],
            ]);
        }
    }
}