<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Role;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Middleware\Authorize;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();

        //Call all the seeders
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            SubjectSeeder::class,
            MajorSeeder::class,
            MajorSubjectSeeder::class,
            AuthorisedStaffSeeder::class,
            PersonalTutorSeeder::class,
            StudentSeeder::class,
            NoteSeeder::class,
            TutoringSessionSeeder::class,
            MeetingSeeder::class,
            ParticipantSeeder::class,
            WebBrowserSeeder::class,
            PageSeeder::class,
            BrowserLogSeeder::class,
            ActivityLogSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
