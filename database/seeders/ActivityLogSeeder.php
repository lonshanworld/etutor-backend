<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('activity_logs')->insert([
            ['user_id' => 1, 'visit_count' => 10, 'ip_address' => '192.168.1.1', 'session_login' => '2025-03-6 08:00:00', 'session_logout' => '2025-03-6 10:00:00'],
            ['user_id' => 2, 'visit_count' => 15, 'ip_address' => '192.168.1.2', 'session_login' => '2025-03-14 09:00:00', 'session_logout' => null],
            ['user_id' => 3, 'visit_count' => 8, 'ip_address' => '192.168.1.3', 'session_login' => '2025-03-1 07:45:00', 'session_logout' => '2025-03-1 09:15:00'],
            ['user_id' => 4, 'visit_count' => 20, 'ip_address' => '192.168.1.4', 'session_login' => '2025-03-1 06:30:00', 'session_logout' => '2025-03-1 08:30:00'],
            ['user_id' => 5, 'visit_count' => 5, 'ip_address' => '192.168.1.5', 'session_login' => '2025-03-14 10:30:00', 'session_logout' => null],
            ['user_id' => 6, 'visit_count' => 12, 'ip_address' => '192.168.1.6', 'session_login' => '2025-03-3 11:00:00', 'session_logout' => '2025-03-3 13:00:00'],
            ['user_id' => 7, 'visit_count' => 18, 'ip_address' => '192.168.1.7', 'session_login' => '2025-02-14 08:30:00', 'session_logout' => '2025-02-14 10:30:00'],
            ['user_id' => 8, 'visit_count' => 7, 'ip_address' => '192.168.1.8', 'session_login' => '2025-03-14 07:00:00', 'session_logout' => '2025-03-14 08:30:00'],
            ['user_id' => 9, 'visit_count' => 25, 'ip_address' => '192.168.1.9', 'session_login' => '2025-03-14 09:30:00', 'session_logout' => null],
            ['user_id' => 10, 'visit_count' => 30, 'ip_address' => '192.168.1.10', 'session_login' => '2025-03-14 10:00:00', 'session_logout' => '2025-03-14 12:30:00'],
            ['user_id' => 11, 'visit_count' => 17, 'ip_address' => '192.168.1.11', 'session_login' => '2025-03-10 08:00:00', 'session_logout' => '2025-03-10 10:00:00'],
            ['user_id' => 12, 'visit_count' => 14, 'ip_address' => '192.168.1.12', 'session_login' => '2025-03-8 09:00:00', 'session_logout' => '2025-03-8 11:00:00'],
            ['user_id' => 13, 'visit_count' => 11, 'ip_address' => '192.168.1.13', 'session_login' => '2025-03-14 07:15:00', 'session_logout' => '2025-03-14 09:15:00'],
            ['user_id' => 14, 'visit_count' => 22, 'ip_address' => '192.168.1.14', 'session_login' => '2025-03-5 06:45:00', 'session_logout' => '2025-03-5 08:45:00'],
            ['user_id' => 15, 'visit_count' => 9, 'ip_address' => '192.168.1.15', 'session_login' => '2025-03-14 10:45:00', 'session_logout' => null],
            ['user_id' => 16, 'visit_count' => 19, 'ip_address' => '192.168.1.16', 'session_login' => '2025-03-14 11:30:00', 'session_logout' => '2025-03-14 13:00:00'],
            ['user_id' => 17, 'visit_count' => 13, 'ip_address' => '192.168.1.17', 'session_login' => '2025-03-5 08:15:00', 'session_logout' => '2025-03-5 10:00:00'],
            ['user_id' => 18, 'visit_count' => 21, 'ip_address' => '192.168.1.18', 'session_login' => '2025-03-10 07:30:00', 'session_logout' => '2025-03-10 09:00:00'],
            ['user_id' => 19, 'visit_count' => 10, 'ip_address' => '192.168.1.19', 'session_login' => '2025-03-14 09:15:00', 'session_logout' => '2025-03-14 11:00:00'],
            ['user_id' => 20, 'visit_count' => 6, 'ip_address' => '192.168.1.20', 'session_login' => '2025-03-14 10:00:00', 'session_logout' => '2025-03-4 11:30:00'],
            ['user_id' => 21, 'visit_count' => 16, 'ip_address' => '192.168.1.21', 'session_login' => '2025-03-14 07:45:00', 'session_logout' => null],
            ['user_id' => 22, 'visit_count' => 12, 'ip_address' => '192.168.1.22', 'session_login' => '2025-03-14 08:30:00', 'session_logout' => '2025-03-14 10:30:00'],
            ['user_id' => 23, 'visit_count' => 27, 'ip_address' => '192.168.1.23', 'session_login' => '2025-03-1 06:15:00', 'session_logout' => '2025-03-1 08:15:00'],
            ['user_id' => 24, 'visit_count' => 24, 'ip_address' => '192.168.1.24', 'session_login' => '2025-03-14 09:00:00', 'session_logout' => null],
            ['user_id' => 25, 'visit_count' => 28, 'ip_address' => '192.168.1.25', 'session_login' => '2025-03-14 10:30:00', 'session_logout' => '2025-03-14 12:30:00'],
            ['user_id' => 26, 'visit_count' => 8, 'ip_address' => '192.168.1.26', 'session_login' => '2025-03-14 06:30:00', 'session_logout' => '2025-02-14 08:00:00'],
            ['user_id' => 27, 'visit_count' => 23, 'ip_address' => '192.168.1.27', 'session_login' => '2025-03-14 07:30:00', 'session_logout' => null],
            ['user_id' => 28, 'visit_count' => 29, 'ip_address' => '192.168.1.28', 'session_login' => '2025-03-9 10:15:00', 'session_logout' => '2025-03-9 12:00:00']
        ]);
    }
}