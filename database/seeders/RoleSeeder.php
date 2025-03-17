<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles creation
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'tutor'],
            ['name' => 'student']
        ]);
    }
}
