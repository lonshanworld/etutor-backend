<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateStaffAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateStaffAccountController extends Controller
{
    public function __invoke(UpdateStaffAccountRequest $updateStaffAccountRequest, string $id)
    {
        try {
            $validatedData = $updateStaffAccountRequest->validated();

            if (isset($validatedData['password_confirmation'])) {
                unset($validatedData['password_confirmation']);
            }

            if (isset($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }

            if ($updateStaffAccountRequest->hasFile('profile_picture')) {
                $file = $updateStaffAccountRequest->file('profile_picture');
                $path = $file->store('etuto/profile', 's3');
                $validatedData['profile_picture'] = Storage::disk('s3')->url($path);
            }

            $userData = User::where('id', $id)->first();
            $userData->update($validatedData);
            
            // Update staff data only if fields exist
            $staffData = array_filter([
                'emergency_contact_name' => $validatedData['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $validatedData['emergency_contact_phone'] ?? null,
                'start_date' => $validatedData['start_date'] ?? null
            ]);

            if (!empty($staffData)) {
                $userData->staff()->update($staffData);
            }

            return response()->success(
                [], 'success', 200
            );

        } catch (\Throwable $th) {
            Log::info('update staff api', [
                'message' => $th->getMessage()
            ]);
            return response()->error('An error occurred while updating the account.', 500);
        }
    }
}
