<?php

namespace App\Http\Controllers\Api\Posts\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentToPostController extends Controller
{
    public function __invoke(StoreCommentRequest $storeCommentRequest)
    {
        try {
            $validated = $storeCommentRequest->validated();
            $post = Post::where('id', $validated['post_id'])->firstOrFail();
            $post->comments()->create([
                'content' => $validated['content'],
                'user_id' => $validated['user_id']
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
