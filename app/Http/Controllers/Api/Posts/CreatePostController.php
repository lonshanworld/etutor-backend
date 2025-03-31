<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreatePostController extends Controller
{
    public function __invoke(CreatePostRequest $createPostRequest)
    {
        try {
            DB::beginTransaction();
            $validatedData = $createPostRequest->validated();
            $validatedData['url_link'] = [];
            $createdNote = auth('sanctum')->user()->posts()->create($validatedData);
            if ($createPostRequest->has('attachments')) {
                foreach ($createPostRequest->validated('attachments') as $attachment) {
                    $createdNote->files()->create([
                        'url_link' => $attachment
                    ]);
                }
            }
            DB::commit();
            return response()->success();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('create post api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
