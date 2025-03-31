<?php

namespace Database\Seeders;

use App\Models\Meeting;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    public function run(): void
    {
        $meetings = [
            [
                'meeting_type' => 'real',
                'meeting_date' => '2025-03-15',
                'meeting_time' => '10:00:00',
                'location' => 'Conference Room 1, Building A',
                'platform' => null,
                'meeting_link' => null
            ],
            [
                'meeting_type' => 'virtual',
                'meeting_date' => '2025-03-16',
                'meeting_time' => '14:00:00',
                'location' => 'online',
                'platform' => 'Zoom',
                'meeting_link' => 'https://zoom.us/j/123456789'
            ],
            [
                'meeting_type' => 'real',
                'meeting_date' => '2025-03-17',
                'meeting_time' => '09:30:00',
                'location' => 'Room 5, Building B',
                'platform' => 'online',
                'meeting_link' => null
            ],
            [
                'meeting_type' => 'virtual',
                'meeting_date' => '2025-03-18',
                'meeting_time' => '15:00:00',
                'location' => 'online',
                'platform' => 'Google Meet',
                'meeting_link' => 'https://meet.google.com/abc-defg-hij'
            ],
            [
                'meeting_type' => 'virtual',
                'meeting_date' => '2025-03-19',
                'meeting_time' => '11:00:00',
                'location' => 'online',
                'platform' => 'Teams',
                'meeting_link' => 'https://teams.microsoft.com/l/meetup-join/1234567890'
            ],
            [
                'meeting_type' => 'real',
                'meeting_date' => '2025-03-20',
                'meeting_time' => '13:00:00',
                'location' => 'Room 3, Building C',
                'platform' => null,
                'meeting_link' => null
            ]
        ];

        foreach ($meetings as $meeting) {
            Meeting::create($meeting);
        }
    }
}
