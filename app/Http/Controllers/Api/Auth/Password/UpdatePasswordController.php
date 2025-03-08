<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdatePasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('email', $request->email)->first();
            $user->update([
                'password' => $request->password
            ]);
            $user->tokens()->delete();
            DB::commit();
            return response()->json([
                'data' => [
                    'status' => true
                ],
                'message' => 'success'
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
