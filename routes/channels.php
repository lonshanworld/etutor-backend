<?php

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
