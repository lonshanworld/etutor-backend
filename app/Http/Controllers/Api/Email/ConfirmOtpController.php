<?php

namespace App\Http\Controllers\Api\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmOtpController extends Controller
{
    public function __invoke(string $otp)
    {
        // check otp here later
        $otpCheck = true;

        if(!$otpCheck) {
            return response()->json([
                'data' => [
                    'status' => false
                ],
                'message' => 'Wrong OTP',

            ]);
        }
        return response()->json([
            'data' => [
                'status' => true
            ],
            'message' => 'OTP Confirmed'
        ]);
    }
}
