<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\DeactivateUserAccountRequest;
use App\Models\User;
use App\Enums\AccountStatus;
use Illuminate\Http\Request;

class DeactivateStudentAccountController extends Controller
{
    public function __invoke(DeactivateUserAccountRequest $deactivateUserAccountRequest)
    {
        try {
            $user = User::findOrFail($deactivateUserAccountRequest->user_id);
            $user->update(['status' => AccountStatus::DEACTIVATED->value]);

            return response()->json([
                'status' => true,
                'message' => 'Account deactiavated successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'failed'
            ]);
        }
    }
}
