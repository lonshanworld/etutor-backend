<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateTutorAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateTutorAccountController extends Controller
{
    public function __invoke(UpdateTutorAccountRequest $updateTutorAccountRequest, string $id)
    {
        try {
            $validatedData = $updateTutorAccountRequest->validated();

            if (isset($validatedData['password_confirmation'])) {
                unset($validatedData['password_confirmation']);
            }

            if (isset($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }

            if ($updateTutorAccountRequest->hasFile('profile_picture')) {
                $file = $updateTutorAccountRequest->file('profile_picture');
                $path = $file->store('etuto/profile', 's3');
                $validatedData['profile_picture'] = Storage::disk('s3')->url($path);
            }

            $userData = User::where('id', $id)->first();
            $userData->update($validatedData);
            
            // Update tutor data only if fields exist
            $tutorData = array_filter([
                'subject_id' => $validatedData['subject_id'] ?? null,
                'qualifications' => $validatedData['qualifications'] ?? null,
                'experience' => $validatedData['experience'] ?? null
            ]);

            if (!empty($tutorData)) {
                $userData->tutor()->update($tutorData);
            }

            return response()->success(
                [], 'success', 200
            );

        } catch (\Throwable $th) {
            Log::info('update tutor api', [
                'message' => $th->getMessage()
            ]);
            return response()->error('An error occurred while updating the account.', 500);
        }
    }
}
