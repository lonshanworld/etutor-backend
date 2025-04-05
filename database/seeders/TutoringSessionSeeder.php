<?php

namespace Database\Seeders;

use App\Models\TutoringSession;
use Illuminate\Database\Seeder;

class TutoringSessionSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = [
            // ['tutor_id' => 1, 'student_id' => 1, 'assigned_by' => 1],
            // ['tutor_id' => 1, 'student_id' => 2, 'assigned_by' => 1],
            // ['tutor_id' => 1, 'student_id' => 3, 'assigned_by' => 1],
            ['tutor_id' => 1, 'student_id' => 4, 'assigned_by' => 1],
            ['tutor_id' => 1, 'student_id' => 5, 'assigned_by' => 1],
            ['tutor_id' => 1, 'student_id' => 6, 'assigned_by' => 1],
            ['tutor_id' => 1, 'student_id' => 7, 'assigned_by' => 1],
            ['tutor_id' => 1, 'student_id' => 8, 'assigned_by' => 1],
            ['tutor_id' => 1, 'student_id' => 9, 'assigned_by' => 1],
            ['tutor_id' => 1, 'student_id' => 10, 'assigned_by' => 1],
            ['tutor_id' => 2, 'student_id' => 11, 'assigned_by' => 1],
            ['tutor_id' => 2, 'student_id' => 12, 'assigned_by' => 1],
            ['tutor_id' => 2, 'student_id' => 13, 'assigned_by' => 1],
            ['tutor_id' => 2, 'student_id' => 14, 'assigned_by' => 1],
            ['tutor_id' => 2, 'student_id' => 15, 'assigned_by' => 1],
            ['tutor_id' => 2, 'student_id' => 16, 'assigned_by' => 1],
            ['tutor_id' => 2, 'student_id' => 17, 'assigned_by' => 1],
            ['tutor_id' => 2, 'student_id' => 18, 'assigned_by' => 1],
            ['tutor_id' => 3, 'student_id' => 19, 'assigned_by' => 1],
            ['tutor_id' => 3, 'student_id' => 20, 'assigned_by' => 1],
        ];

        foreach ($sessions as $session) {
            TutoringSession::create($session);
        }
    }
}
