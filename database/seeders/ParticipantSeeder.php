<?php

namespace Database\Seeders;

use App\Models\Participant;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        // Meeting 1 (Real) - Room 101
        $meeting1Participants = [
            ['meeting_id' => 1, 'user_id' => 3],
            ['meeting_id' => 1, 'user_id' => 7],
            ['meeting_id' => 1, 'user_id' => 8],
            ['meeting_id' => 1, 'user_id' => 9],
            ['meeting_id' => 1, 'user_id' => 10],
            ['meeting_id' => 1, 'user_id' => 11],
            ['meeting_id' => 1, 'user_id' => 12],
            ['meeting_id' => 1, 'user_id' => 13],
            ['meeting_id' => 1, 'user_id' => 14],
            ['meeting_id' => 1, 'user_id' => 15],
            ['meeting_id' => 1, 'user_id' => 16],
        ];

        // Meeting 2 (Virtual) - Zoom
        $meeting2Participants = [
            ['meeting_id' => 2, 'user_id' => 4],
            ['meeting_id' => 2, 'user_id' => 17],
            ['meeting_id' => 2, 'user_id' => 18],
            ['meeting_id' => 2, 'user_id' => 19],
            ['meeting_id' => 2, 'user_id' => 20],
            ['meeting_id' => 2, 'user_id' => 21],
            ['meeting_id' => 2, 'user_id' => 22],
            ['meeting_id' => 2, 'user_id' => 23],
            ['meeting_id' => 2, 'user_id' => 24],
        ];

        // Meeting 3 (Real) - Library
        $meeting3Participants = [
            ['meeting_id' => 3, 'user_id' => 5],
            ['meeting_id' => 3, 'user_id' => 25],
            ['meeting_id' => 3, 'user_id' => 26],
        ];

        $allParticipants = array_merge(
            $meeting1Participants,
            $meeting2Participants,
            $meeting3Participants
        );

        foreach ($allParticipants as $participant) {
            Participant::create($participant);
        }
    }
}