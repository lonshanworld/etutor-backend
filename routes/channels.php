<?php

use App\Http\Controllers\ActivityLogController;
use App\Listeners\UpdateSessionLogoutTime;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
//     return true;
// });


// Presence channel for tracking online users
Broadcast::channel('presence.online-users', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'role' => $user->role,
        'email' => $user->email,
        'profile_photo' => $user->profile_photo,
    ];
});

// Broadcast::channel('userooms', function(User $user, $id) {
//     return true;
// });

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Broadcast::channel('rooms.{id}', function(User $user, $id) {
    $foundUser = User::find($id);
    // return $user;
    // return $user;
    return [
        'id' => $user->id,
        'email' => $user->email,
        'foundUser' => $foundUser
    ];
});

Broadcast::channel('session_login', function ($user) {
    \Log::info("Auth request received for presence.session from user: {$user->id}");
    if ($user->id) {
        $activityLog = ActivityLog::where('user_id', $user->id)->first();

        if ($activityLog) {
            $activityLog->session_login = Carbon::now();
            $activityLog->visit_count += 1;
            $activityLog->save();
        }
    }

    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('session_logout', function ($user) {
    \Log::info("Auth request received for presence.session from user: {$user->id}");
    if ($user->id) {
        $activityLog = ActivityLog::where('user_id', $user->id)->first();

        if ($activityLog) {
            $activityLog->session_logout = Carbon::now();
            $activityLog->save();
        }

    }

    return ['id' => $user->id, 'name' => $user->name];
});
