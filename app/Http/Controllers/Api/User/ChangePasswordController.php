<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $changePasswordRequest)
    {
        try {
            $changePasswordRequest->user()
            ->update([
                'password' => Hash::make($changePasswordRequest->validated()['password'])
            ]);

            return response()->success();
        } catch (\Throwable $th) {
            //throw $th;
            Log::info('change password', [
                'message' => $th->getMessage()
            ]);

            return response()->error();
        }
    }
}
