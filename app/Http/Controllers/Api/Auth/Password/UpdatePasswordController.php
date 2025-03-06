<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UpdatePasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            $user->update([
                'password' => $request->password
            ]);
            return response()->json([
                'data' => [
                    'status' => true
                ],
                'message' => 'password updated!'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'data' => [],
                'message' => 'something went wrong!'
            ], 500);
        }
    }
}
