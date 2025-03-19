<?php

namespace App\Http\Controllers\Api\Email;

use App\Http\Controllers\Controller;
use App\Mail\Message\SendOtp;  // This is the correct import
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CheckEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();

            // Check if email exists in users table
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'data' => [
                        'status' => false
                    ],
                    'message' => 'Email not found'
                ], 404);
            }

            // Delete any existing OTPs
            UserOtp::where('email', $request->email)
                ->where(function ($query) {
                    $query->where('created_at', '<=', now()->subMinutes(5))
                          ->orWhere('confirmed', true);
                })
                ->delete();

            $otp = rand(100000, 999999);
            
            // Store OTP
            UserOtp::create([
                'email' => $request->email,
                'otp' => $otp,
                'confirmed' => false
            ]);

            Mail::to($request->email)->send(new SendOtp($otp));

            DB::commit();
            return response()->json([
                'data' => [
                    'status' => true,
                    'otp' => $otp // Add OTP to response for testing
                ],
                'message' => 'OTP sent successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'data' => [],
                'message' => 'Failed to send OTP'
            ], 500);
        }
    }
}
