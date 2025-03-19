<?php

namespace App\Http\Controllers\Api\Email;

use App\Http\Controllers\Controller;
use App\Mail\Message\SendOtp;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'data' => [
                    'status' => true
                ],
                'message' => 'Email Not Found!'
            ], 404);
        }
        $otp = rand(100000, 999999);
        UserOtp::upsert(
            [
                [
                    'otp' => $otp,
                    'email' => $user->email
                ],
            ],
            ['email'],
            ['otp']
        );

        Mail::to($user->email)->send(new SendOtp($otp));
        return response()->success(
            [
                'otp' => $otp
            ],
            'Email Found!',
            200
        );
    }
}