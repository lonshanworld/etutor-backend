<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\ToggleUserAccountStatusRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ToggleUserAccountStatusController extends Controller
{
    public function __invoke(ToggleUserAccountStatusRequest $toggleUserAccountStatusRequest)
    {
        try {
            $user = User::findOrFail($toggleUserAccountStatusRequest->user_id);
            
            $newStatus = $user->status === 'activate' ? 'deactivate' : 'activate';
            $user->update(['status' => $newStatus]);
            
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
