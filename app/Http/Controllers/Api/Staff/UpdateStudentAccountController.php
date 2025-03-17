<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateUserAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

            if ($updateUserAccountRequest->hasFile('profile_picture')) {
                $file = $updateUserAccountRequest->file('profile_picture');
                $path = $file->store('etuto/profile', 's3');
                $validatedData['profile_picture'] = Storage::disk('s3')->url($path);
            }

            $userData = User::where('id', $id)->first();
            $userData->update($validatedData);
            
            $userData->student()->update([
                'major_id' => $validatedData['major_id'],
                'emergency_contact_name' => $validatedData['emergency_contact_name'],
                'emergency_contact_phone' => $validatedData['emergency_contact_phone'],
            ]);

            return response()->success(
                [], 'success', 200
            );

        } catch (\Throwable $th) {
            Log::info('update student api', [
                'message' => $th->getMessage()
            ]);
            return response()->error('An error occurred while creating the account.', 500);
        }
    }
}
