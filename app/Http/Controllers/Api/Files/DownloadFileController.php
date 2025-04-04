<?php

namespace App\Http\Controllers\Api\Files;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadFileController extends Controller
{
    public function __invoke(Request $request): StreamedResponse|JsonResponse
    {
        try {
            $fileId = $request->route('id');
            $file = File::where('id', $fileId)->firstOrFail();
            
            // Construct the file path
            $filePath = 'etuto/attachments/' . $file->file_name;
            
            // Check if file exists in S3 storage
            if (!Storage::disk('s3')->exists($filePath)) {
                return response()->json([
                    'message' => 'File not found on storage'
                ], 404);
            }
            
            // Download the file from S3 storage
            return Storage::disk('s3')->download(
                $filePath, 
                $file->file_name
            );
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to download file',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
