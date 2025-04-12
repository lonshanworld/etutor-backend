<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfilePictureRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateProfilePictureController extends Controller
{
    public function __invoke(UpdateProfilePictureRequest $updateProfilePictureRequest)
    {
        Log::info('request body',[
            'body' => $updateProfilePictureRequest->all()
        ]);
        
        try {
            $validated = $updateProfilePictureRequest->validated();
            $profilePicture = $validated['profile_picture'];

            $originalFilename = $profilePicture->getClientOriginalName();
            $path = $profilePicture->storeAs('etuto/attachments', $originalFilename, 's3');
            Storage::disk('s3')->url($path);

            return response()->json([
                'message' => 'updated'
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            Log::info('profile picture update api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
