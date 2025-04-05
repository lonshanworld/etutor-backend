<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrowserLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logs = [
            ['log_id' => 1, 'browser_id' => 1],
            ['log_id' => 2, 'browser_id' => 2],
            ['log_id' => 3, 'browser_id' => 1],
            ['log_id' => 4, 'browser_id' => 3],
            ['log_id' => 5, 'browser_id' => 4],
            ['log_id' => 6, 'browser_id' => 5],
            ['log_id' => 7, 'browser_id' => 6],
            ['log_id' => 8, 'browser_id' => 1],
            ['log_id' => 9, 'browser_id' => 3],
            ['log_id' => 10, 'browser_id' => 4],
            ['log_id' => 11, 'browser_id' => 1]
        ];

        foreach ($logs as $log) {
            DB::table('browser_logs')->insert([
                'log_id' => $log['log_id'],
                'browser_id' => $log['browser_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}