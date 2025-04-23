<?php

use App\Notifications\User\InactiveUserNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    
    Log::info('This is a scheduled task that runs every five seconds.', [
        'time' => now()->toDateTimeString(),
    ]);
    
    try {
        $inactiveUsers = User::whereHas(
            'activityLog',
            function ($query) {
                
                $query->where('session_logout', '<=', Carbon::now()->subDays(28))
                    
                    ->whereRaw('session_login < session_logout');
            }
        )
            ->orWhereDoesntHave('activityLog')
            ->get();

        $notifiedCount = 0;

        foreach ($inactiveUsers as $user) {
            try {               
                if (empty($user->email)) {
                    Log::warning("User ID {$user->id} is missing email address, skipping notification");
                    continue;
                }
                
                $user->notify(new InactiveUserNotification());
                $notifiedCount++;
                
            } catch (\Exception $e) {
                Log::error("Failed to send inactive user notification to {$user->email}: {$e->getMessage()}", [
                    'exception' => get_class($e),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);                
            }
        }
        
        Log::info("Completed inactive user check", [
            'total_users_found' => $inactiveUsers->count(),
            'notifications_sent' => $notifiedCount
        ]);
    } catch (\Exception $e) {
        Log::error("Error in scheduled inactive user check: {$e->getMessage()}", [
            'exception' => get_class($e),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
    }
})->everyThirtySeconds();
