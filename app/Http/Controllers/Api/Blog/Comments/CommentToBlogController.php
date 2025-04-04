<?php

namespace App\Http\Controllers\Api\Blog\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\Api\Blogs\CommentResource;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class CommentToBlogController extends Controller
{
    public function __invoke(StoreCommentRequest $storeCommentRequest)
    {
        try {
            $validated = $storeCommentRequest->validated();
            $user = auth('sanctum')->user();
            $post = Blog::where('id', $validated['blog_id'])->firstOrFail();

            // $post->comments()->create([
            //     'content' => $validated['content'],
            //     'user_id' => $user->id
            // ]);

            if(! $post) {
                return response()->error('Blog not found', 404);
            }

           $comment = Comment::create([
                'content' => $validated['content'],
                'user_id' => $user->id,
                'blog_id' => $post->id
            ]);
            

            return response()->success([
                'comment' => new CommentResource($comment->load('user'))
            ]);
        } catch (\Throwable $th) {
            Log::error('comment post api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
