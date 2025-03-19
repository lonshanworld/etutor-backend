<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use App\Http\Requests\User\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $UpdatePasswordRequest)
    {
        try {
            DB::beginTransaction();

            // First check if OTP exists and is confirmed
            $otpStatus = UserOtp::where('email', $UpdatePasswordRequest->email)
                ->where('otp', $UpdatePasswordRequest->otp)
                ->where('confirmed', true)
                ->first();

            if (!$otpStatus) {
                return response()->json([
                    'data' => [
                        'status' => false
                    ],
                    'message' => 'Invalid OTP or OTP not confirmed'
                ], 403);
            }
            
            $user = User::where('email', $UpdatePasswordRequest->email)->first();
            $user->update([
                'password' => bcrypt($UpdatePasswordRequest->password)
            ]);
            
            // Delete the used OTP
            $otpStatus->delete();
            
            // Revoke all tokens for security
            $user->tokens()->delete();
            
            DB::commit();
            return response()->json([
                'data' => [
                    'status' => true
                ],
                'message' => 'Password updated successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'data' => [],
                'message' => 'something went wrong'
            ], 500);
        }
    }
}
