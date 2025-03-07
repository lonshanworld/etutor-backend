<?php

namespace App\Http\Controllers\Api\Email;

use App\Http\Controllers\Controller;
use App\Mail\Message\SendOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return response()->json([
                'data' => [
                    'status' => true
                ],
                'message' => 'email not found!'
            ], 404);
        }
        // send otp to email
        $otp = rand(100000, 999999);
        Mail::to($request->email)->send(new SendOtp($otp));
        return response()->json([
            'data' => [
                'otp' => $otp
            ],
            'message' => 'email found!'
        ], 200);
    }
}
