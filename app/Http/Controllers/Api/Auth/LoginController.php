<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $loginRequest)
    {
        try {
            $user = User::where('email', $loginRequest->email)->first();

            if (! $user || ! Hash::check($loginRequest->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            return response()->json([
                'message' => 'success',
                'token' => $user->createToken($loginRequest->device_name ?? 'web_app')->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
