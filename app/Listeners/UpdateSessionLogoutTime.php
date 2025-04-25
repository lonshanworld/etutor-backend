<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateSessionLogoutTime
{
    /**
     * Create the event listener.
     */

    /**
     * Handle the event.
     */
    public function handle(\Laravel\Reverb\Events\ConnectionPruned $event)
    {
        $connection = $event->connection;

        $userId = $connection->user()?->id;

        $activityLog = ActivityLog::where('user_id', 1)->first();

        if ($activityLog) {
            // Update the session_login field with the current timestamp
            $activityLog->session_logout = Carbon::now();
            $activityLog->save();
        }  // Example: update session logout time
    }
}
