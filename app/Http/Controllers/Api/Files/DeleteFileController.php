<?php

namespace App\Http\Controllers\Api\Files;

use App\Http\Controllers\Controller;
use App\Http\Requests\Files\DeleteFileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteFileController extends Controller
{
    public function __invoke(DeleteFileRequest $deleteFileRequest)
    {
        try {
            $validated = $deleteFileRequest->validated();
            $file = File::findOrFail($validated['id']);
            Storage::disk('s3')->delete($file->url_link);
            $file->delete();
            return response()->json([
                'message' => 'File deleted successfully'
            ]);
        } catch (\Throwable $th) {
            Log::info('delete file api', [
                'message' => $th->getMessage(),
            ]);
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
