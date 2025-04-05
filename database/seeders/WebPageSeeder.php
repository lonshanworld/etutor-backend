<?php

namespace Database\Seeders;

use App\Models\WebPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['name' => '/home', 'view_count' => 1500],
            ['name' => '/meeting', 'view_count' => 700],
            ['name' => '/chat', 'view_count' => 450],
            ['name' => '/note', 'view_count' => 900],
            ['name' => '/blog', 'view_count' => 1200],
            ['name' => '/people', 'view_count' => 600],
            ['name' => '/blog', 'view_count' => 850],
        ];

        foreach ($pages as $page) {
            DB::table('web_pages')->insert([
                'name' => $page['name'],
                'view_count' => $page['view_count'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}