<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $majorSubjects = [
            // Computer Science
            ['major_id' => 1, 'subject_id' => 1],
            ['major_id' => 1, 'subject_id' => 2],
            ['major_id' => 1, 'subject_id' => 3],
            ['major_id' => 1, 'subject_id' => 4],
            ['major_id' => 1, 'subject_id' => 5],
            ['major_id' => 1, 'subject_id' => 6],
            ['major_id' => 1, 'subject_id' => 7],

            // Information Technology
            ['major_id' => 2, 'subject_id' => 8],
            ['major_id' => 2, 'subject_id' => 9],
            ['major_id' => 2, 'subject_id' => 10],
            ['major_id' => 2, 'subject_id' => 11],
            ['major_id' => 2, 'subject_id' => 12],

            // Software Engineering
            ['major_id' => 3, 'subject_id' => 13],
            ['major_id' => 3, 'subject_id' => 14],
            ['major_id' => 3, 'subject_id' => 15],
            ['major_id' => 3, 'subject_id' => 16],
            ['major_id' => 3, 'subject_id' => 17],

            // Data Science
            ['major_id' => 4, 'subject_id' => 18],
            ['major_id' => 4, 'subject_id' => 19],
            ['major_id' => 4, 'subject_id' => 20],
            ['major_id' => 4, 'subject_id' => 21],
            ['major_id' => 4, 'subject_id' => 22],

            // Cybersecurity
            ['major_id' => 5, 'subject_id' => 23],
            ['major_id' => 5, 'subject_id' => 24],
            ['major_id' => 5, 'subject_id' => 25],
            ['major_id' => 5, 'subject_id' => 26],
            ['major_id' => 5, 'subject_id' => 27],

            // Business Administration
            ['major_id' => 6, 'subject_id' => 28],
            ['major_id' => 6, 'subject_id' => 29],
            ['major_id' => 6, 'subject_id' => 30],
            ['major_id' => 6, 'subject_id' => 31],
            ['major_id' => 6, 'subject_id' => 32],

            // Accounting and Finance
            ['major_id' => 7, 'subject_id' => 33],
            ['major_id' => 7, 'subject_id' => 34],
            ['major_id' => 7, 'subject_id' => 35],
            ['major_id' => 7, 'subject_id' => 36],
            ['major_id' => 7, 'subject_id' => 37],

            // Marketing
            ['major_id' => 8, 'subject_id' => 38],
            ['major_id' => 8, 'subject_id' => 39],
            ['major_id' => 8, 'subject_id' => 40],
            ['major_id' => 8, 'subject_id' => 41],
            ['major_id' => 8, 'subject_id' => 42],

            // Mechanical Engineering
            ['major_id' => 9, 'subject_id' => 43],
            ['major_id' => 9, 'subject_id' => 44],
            ['major_id' => 9, 'subject_id' => 45],
            ['major_id' => 9, 'subject_id' => 46],
            ['major_id' => 9, 'subject_id' => 47],

            // Graphic Design
            ['major_id' => 10, 'subject_id' => 48],
            ['major_id' => 10, 'subject_id' => 49],
            ['major_id' => 10, 'subject_id' => 50],
            ['major_id' => 10, 'subject_id' => 51],
            ['major_id' => 10, 'subject_id' => 52],

            // Psychology
            ['major_id' => 11, 'subject_id' => 53],
            ['major_id' => 11, 'subject_id' => 54],
            ['major_id' => 11, 'subject_id' => 55],
            ['major_id' => 11, 'subject_id' => 56],

            // Law
            ['major_id' => 12, 'subject_id' => 57],
            ['major_id' => 12, 'subject_id' => 58],
            ['major_id' => 12, 'subject_id' => 59],
            ['major_id' => 12, 'subject_id' => 60],

            // Education
            ['major_id' => 13, 'subject_id' => 61],
            ['major_id' => 13, 'subject_id' => 62],
            ['major_id' => 13, 'subject_id' => 63],

            // Environmental Science
            ['major_id' => 14, 'subject_id' => 64],
            ['major_id' => 14, 'subject_id' => 65],
            ['major_id' => 14, 'subject_id' => 66],
            ['major_id' => 14, 'subject_id' => 67],
        ];

        foreach ($majorSubjects as $majorSubject) {
            DB::table('major_subjects')->insert([
                'major_id' => $majorSubject['major_id'],
                'subject_id' => $majorSubject['subject_id'],
            ]);
        }
    }
}