<?php

namespace App\Http\Controllers\Api\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmOtpRequest;
use App\Models\UserOtp;
use Illuminate\Http\Request;

class ConfirmOtpController extends Controller
{
    public function __invoke(ConfirmOtpRequest $confirmOtpRequest)
    {
        $otpCheck = UserOtp::where('email', $confirmOtpRequest->email)->where('otp', $confirmOtpRequest->otp)->first();
        if (!$otpCheck) {
            return response()->json([
                'data' => [
                    'status' => false
                ],
                'message' => 'Invalid OTP',
            ]);
        }
        $otpCheck->update([
            'confirmed' => true
        ]);
        return response()->json([
            'data' => [
                'status' => true
            ],
            'message' => 'OTP Confirmed'
        ]);
    }
}
