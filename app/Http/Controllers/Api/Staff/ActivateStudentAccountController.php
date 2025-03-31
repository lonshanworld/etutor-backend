<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\ActivateStudentAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ActivateStudentAccountController extends Controller
{
    public function __invoke(ActivateStudentAccountRequest $activateStudentAccountRequest)
    {
        try {
            User::where('id', $activateStudentAccountRequest->user_id)->first()->update([
                'status' => 'activate'
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
