<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateUserAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateStudentAccountController extends Controller
{
    public function __invoke(UpdateUserAccountRequest $updateUserAccountRequest, string $id)
    {
        try {
            $validatedData = $updateUserAccountRequest->validated();

            if (isset($validatedData['password_confirmation'])) {
                unset($validatedData['password_confirmation']);
            }

            if (isset($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }
            User::where('id', $id)->first()->update($validatedData);

            return response()->success(
            [], 'success', 200);

        } catch (\Throwable $th) {
            Log::info('update student api', [
                'message' => $th->getMessage()
            ]);
            return response()->error('An error occurred while creating the account.', 500);
        }
    }
}
