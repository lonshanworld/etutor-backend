<?php

namespace App\Http\Controllers\Api\Attachments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attachment\StoreAttachmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadAttachmentController extends Controller
{
    public function __invoke(StoreAttachmentRequest $storeAttachmentRequest)
    {
        try {
            $paths = [];
            foreach ($storeAttachmentRequest->validated('attachments') as $attachment) {
                $originalFilename = $attachment->getClientOriginalName();
                $path = $attachment->storeAs('etuto/attachments', $originalFilename, 's3');
                array_push(
                    $paths,
                    [
                        'name' => $originalFilename,
                        'path' => Storage::disk('s3')->url($path)
                    ]
                );
            }
            return response()->json([
                'data' => $paths
            ], 200);
        } catch (\Throwable $th) {
            Log::error('upload attachment api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
