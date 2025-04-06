<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\ActivateStudentAccountRequest;
use App\Models\User;
use App\Enums\AccountStatus;
use Illuminate\Http\Request;

class ActivateStudentAccountController extends Controller
{
    public function __invoke(ActivateStudentAccountRequest $activateStudentAccountRequest)
    {
        try {
            $user = User::findOrFail($activateStudentAccountRequest->user_id);
            $user->update(['status' => AccountStatus::ACTIVATED->value]);

            return response()->json([
                'status' => true,
                'message' => 'Account activated successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'failed'
            ]);
        }
    }
}
