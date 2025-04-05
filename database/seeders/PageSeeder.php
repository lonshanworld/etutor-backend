<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['url' => '/home', 'view_count' => 1500],
            ['url' => '/meeting', 'view_count' => 700],
            ['url' => '/chat', 'view_count' => 450],
            ['url' => '/note', 'view_count' => 900],
            ['url' => '/blog', 'view_count' => 1200],
            ['url' => '/people', 'view_count' => 600],
            ['url' => '/profile', 'view_count' => 850],
        ];

        foreach ($pages as $page) {
            DB::table('pages')->insert([
                'url' => $page['url'],
                'view_count' => $page['view_count'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}