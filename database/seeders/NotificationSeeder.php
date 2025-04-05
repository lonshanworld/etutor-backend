<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            ['user_id' => 1, 'sender_id' => 2, 'title' => 'Meeting Reminder', 'description' => 'You have a scheduled meeting tomorrow at 10:00 AM.', 'is_read' => 0],
            ['user_id' => 3, 'sender_id' => 1, 'title' => 'Account Alert', 'description' => 'Your account password was recently changed.', 'is_read' => 1],
            ['user_id' => 2, 'sender_id' => 3, 'title' => 'New Message', 'description' => 'You have received a new message from User 3.', 'is_read' => 0],
            ['user_id' => 4, 'sender_id' => 1, 'title' => 'System Update', 'description' => 'A new system update is available. Please update your system.', 'is_read' => 0],
            ['user_id' => 5, 'sender_id' => 2, 'title' => 'Event Invitation', 'description' => 'You have been invited to the company event happening next week.', 'is_read' => 1],
            ['user_id' => 6, 'sender_id' => 3, 'title' => 'Task Deadline', 'description' => 'Your task is due tomorrow at 5:00 PM.', 'is_read' => 0],
            ['user_id' => 7, 'sender_id' => 4, 'title' => 'Promotion Notification', 'description' => 'Congratulations! You have been promoted to a new position.', 'is_read' => 1],
            ['user_id' => 8, 'sender_id' => 5, 'title' => 'Security Alert', 'description' => 'We detected a new login from an unknown device.', 'is_read' => 0],
            ['user_id' => 9, 'sender_id' => 6, 'title' => 'Account Verification', 'description' => 'Please verify your account by clicking the link below.', 'is_read' => 0],
            ['user_id' => 10, 'sender_id' => 7, 'title' => 'Password Reset', 'description' => 'Click the link to reset your password.', 'is_read' => 1]
        ];

        foreach ($notifications as $notification) {
            DB::table('notifications')->insert([
                'user_id' => $notification['user_id'],
                'sender_id' => $notification['sender_id'],
                'title' => $notification['title'],
                'description' => $notification['description'],
                'is_read' => $notification['is_read'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}