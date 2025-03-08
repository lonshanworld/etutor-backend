<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $loginRequest)
    {
        try {
            $user = User::where('email', $loginRequest->email)->first();

            if (!Hash::check($loginRequest->password, $user->password)) {
                return response()->error('The provided credentials are incorrect.', 422);
            }

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Login Action',
                'ip_address' => $loginRequest->ip(),
                'user_agents' => $loginRequest->userAgent(),
            ]);

            return response()->json([
                'message' => 'success',
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
