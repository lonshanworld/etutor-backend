<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $notes = [
            ['user_id' => 10, 'content' => 'Review chapter 3 for the upcoming exam.'],
            ['user_id' => 11, 'content' => 'Meeting notes from the tutor session.'],
            ['user_id' => 12, 'content' => 'List of research topics for the semester project.'],
            ['user_id' => 13, 'content' => 'Reminders: Submit assignment by Friday.'],
            ['user_id' => 14, 'content' => 'Key takeaways from today\'s lecture.'],
            ['user_id' => 15, 'content' => 'Draft ideas for my final year thesis.'],
            ['user_id' => 16, 'content' => 'Personal study plan for next month.'],
            ['user_id' => 17, 'content' => 'Important SQL commands for database management.'],
            ['user_id' => 18, 'content' => 'Notes from the guest lecture on AI.'],
            ['user_id' => 19, 'content' => 'Checklist for group project tasks.'],
            ['user_id' => 20, 'content' => 'Summary of last week\'s study group discussion.'],
            ['user_id' => 21, 'content' => 'Must-read reference books for data structures and algorithms.'],
            ['user_id' => 22, 'content' => 'Steps to optimize a query in MySQL.'],
        ];

        foreach ($notes as $note) {
            Note::create($note);
        }
    }
}
