<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\DeactivateUserAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;

class DeactivateStudentAccountController extends Controller
{
    public function __invoke(DeactivateUserAccountRequest $deactivateUserAccountRequest)
    {
        try {
            User::where('id', $deactivateUserAccountRequest->user_id)->first()->update([
                'status' => 'deactivated'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'failed'
            ]);
        }
    }
}
