<?php

namespace App\Http\Controllers\Api\Attachments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attachment\StoreAttachmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadAttachmentController extends Controller
{
    public function __invoke(StoreAttachmentRequest $storeAttachmentRequest)
    {
        $paths = [];
        foreach ($storeAttachmentRequest->validated('attachments') as $attachment) {
            $path = $attachment->store('etuto/attchments', 's3');
            array_push($paths, Storage::disk('s3')->url($path));
        }
        return $paths;
    }
}