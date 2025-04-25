<?php

namespace App\Listeners;

use App\Events\SessionLoginEvent;
use App\Models\ActivityLog;
use Carbon\Carbon;

class UpdateSessionLoginTime
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\SessionLoginEvent  $event
     * @return void
     */
    public function handle(SessionLoginEvent $event)
    {
        $this->updateSessionLogin($event->userId);
    }

    /**
     * Update the session_login timestamp in the ActivityLog model.
     */
    protected function updateSessionLogin($userId)
    {
        $activityLog = ActivityLog::where('user_id', $userId)->first();

        if ($activityLog) {
            // Update the session_login field with the current timestamp
            $activityLog->session_login = Carbon::now();
            $activityLog->save();
        } else {
            // Handle case when no activity log is found for the user
            // You might want to log this or create a new activity log
        }
    }
}
