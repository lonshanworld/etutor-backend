<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Notifications\User\LogoutNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Logoutcontroller extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            $user->activityLog()->update([
                'session_logout' => Carbon::now()
            ]);
            $user->notify(new LogoutNotification());
            $user->tokens()->delete();
            return response()->noContent();
        } catch (\Throwable $th) {
            throw $th;
            return response()->error();
        }
    }
}
