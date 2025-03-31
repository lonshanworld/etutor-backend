<?php

namespace App\Http\Controllers\Api\Blog\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;

class CommentToBlogController extends Controller
{
    public function __invoke(StoreCommentRequest $storeCommentRequest)
    {
        try {
            $validated = $storeCommentRequest->validated();
            $user = auth('sanctum')->user();
            $post = Blog::where('id', $validated['blog_id'])->firstOrFail();
            $post->comments()->create([
                'content' => $validated['content'],
                'user_id' => $user->id
            ]);

            return response()->success();
        } catch (\Throwable $th) {
            Log::error('comment post api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
