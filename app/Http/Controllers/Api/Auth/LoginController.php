<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use App\Models\User;
use App\Notifications\User\LoginNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $loginRequest)
    {
        try {
            $user = User::where('email', $loginRequest->email)->first();
            if (! $user) {
                return response()->error('The email address you entered was not found. Please check and try again!', 422);
            }
            if (!Hash::check($loginRequest->password, $user->password)) {
                return response()->error('The password you entered was incorrect!.', 401);
            }

            $lastLogin = ActivityLog::where('user_id', $user->id)->first();

            $message = $lastLogin
                ? "Welcome back! Last login was on " . Carbon::parse($lastLogin->session_login)->setTimezone('Asia/Yangon')->format('d-m-Y')
                : "Welcome to eTuto! First time login.";

            if (! $lastLogin) {
                ActivityLog::create([
                    'user_id' => $user->id,
                    'ip_address' => $loginRequest->ip(),
                    'session_login' => Carbon::now()
                ]);
            } else {
                $lastLogin->update([
                    'session_login' => Carbon::now()
                ]);
            }

            $user->notify(new LoginNotification($message));


            return response()->json([
                'message' => $message,
                'token' => $user->createToken($loginRequest->device_name ?? 'web_app')->plainTextToken
            ]);
        } catch (\Throwable $th) {
            Log::error('server error', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
