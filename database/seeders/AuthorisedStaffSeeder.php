<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorisedStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authorized_staff')->insert([
            [
                'user_id' => 1,
                'emergency_contact_name' => 'Michael Smith',
                'emergency_contact_phone' => '123-555-7890',
                'start_date' => '2023-01-10',
                'end_date' => null,
                'created_by' => 1,
                'created_at' => now(),
                'deleted_by' => null,
                'deleted_at' => null,
                'updated_by' => 1,
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'emergency_contact_name' => 'Sarah Johnson',
                'emergency_contact_phone' => '987-555-3210',
                'start_date' => '2023-02-15',
                'end_date' => null,
                'created_by' => 1,
                'created_at' => now(),
                'deleted_by' => null,
                'deleted_at' => null,
                'updated_by' => 1,
                'updated_at' => now()
            ]
        ]);
    }
}