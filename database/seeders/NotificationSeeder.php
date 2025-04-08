<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'type' => 'App\Notifications\MeetingReminder',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 1,
                'data' => json_encode([
                    'title' => 'Meeting Reminder',
                    'message' => 'You have a scheduled meeting tomorrow at 10:00 AM.',
                    'action_url' => '/meetings/1'
                ])
            ],
            [
                'type' => 'App\Notifications\AccountAlert',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 2,
                'data' => json_encode([
                    'title' => 'Account Alert',
                    'message' => 'Your account password was recently changed.',
                    'action_url' => '/settings/security'
                ])
            ],
            [
                'type' => 'App\Notifications\NewMessage',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 3,
                'data' => json_encode([
                    'title' => 'New Message',
                    'message' => 'You have received a new message from User 3.',
                    'action_url' => '/messages/inbox'
                ])
            ],
            [
                'type' => 'App\Notifications\SystemUpdate',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 4,
                'data' => json_encode([
                    'title' => 'System Update',
                    'message' => 'A new system update is available. Please update your system.',
                    'action_url' => '/system/updates'
                ])
            ],
            [
                'type' => 'App\Notifications\EventInvitation',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 5,
                'data' => json_encode([
                    'title' => 'Event Invitation',
                    'message' => 'You have been invited to the company event happening next week.',
                    'action_url' => '/events/5'
                ])
            ]
        ];

        foreach ($notifications as $notification) {
            DB::table('notifications')->insert([
                'id' => Str::uuid(),
                'type' => $notification['type'],
                'notifiable_type' => $notification['notifiable_type'],
                'notifiable_id' => $notification['notifiable_id'],
                'data' => $notification['data'],
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}