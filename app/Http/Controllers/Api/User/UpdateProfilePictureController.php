<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfilePictureRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateProfilePictureController extends Controller
{
    public function __invoke(Request $request)
    {   
        try {
            $profilePicture = $request->file('1_profile_picture');

            $originalFilename = $profilePicture->getClientOriginalName();
            $path = $profilePicture->storeAs('etuto/attachments', $originalFilename, 's3');
            $storedPath = Storage::disk('s3')->url($path);
            // 'path' => Storage::disk('s3')->url($path)
            $user = auth('sanctum')->user();
            // $user->profile_picture = $storedPath;
            // $user->save();
            $user->update([
                'profile_picture' => $storedPath
            ]);

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
