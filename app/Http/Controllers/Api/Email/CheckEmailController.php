<?php

namespace App\Http\Controllers\Api\Email;

use App\Http\Controllers\Controller;
use App\Mail\Message\SendOtp;
use App\Models\User;
use Illuminate\Http\Request;

class CheckEmailController extends Controller
{
    public function __invoke(string $email)
    {
        $user = User::where('email', $email)->first();
        if(!$user) {
            return response()->json([
                'data' => [
                    'status' => true
                ],
                'message' => 'email not found!'
            ], 404);
        }
        // send otp to email
        new SendOtp();
        return response()->json([
            'data' => [],
            'message' => 'email found!'
        ], 200);
    }
}
