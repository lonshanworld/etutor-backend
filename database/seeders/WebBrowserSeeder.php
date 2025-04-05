<?php

namespace Database\Seeders;

use App\Models\WebBrowser;
use Illuminate\Database\Seeder;

class WebBrowserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $browsers = [
            ['name' => 'Google Chrome', 'usage_count' => 1200],
            ['name' => 'Mozilla Firefox', 'usage_count' => 450],
            ['name' => 'Microsoft Edge', 'usage_count' => 300],
            ['name' => 'Safari', 'usage_count' => 600],
            ['name' => 'Opera', 'usage_count' => 150],
            ['name' => 'Brave', 'usage_count' => 100],
        ];

        foreach ($browsers as $browser) {
            WebBrowser::create($browser);
        }
    }
}