<?php

namespace App\Http\Controllers\Api\Blog\Likes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Like\StoreLikeRequest;
use Illuminate\Support\Facades\Log;
use App\Models\Blog;

class ToggleLikeToBlogController extends Controller
{
    public function __invoke(StoreLikeRequest $storeLikeRequest)
    {
        try {
            $validated = $storeLikeRequest->validated();
            $user = auth('sanctum')->user();
            $post = Blog::find($validated['blog_id']);

            if (!$post) {
                return response()->error('Blog post not found', 404);
            }

            if ($post->likes()->where('user_id', $user->id)->exists()) {
                $post->likes()->where('user_id', $user->id)->delete();
                return response()->success([], 'Blog post unliked successfully');
            }
            $post->likes()->create([
                'user_id' => $user->id
            ]);
            return response()->success([], 'Blog post liked successfully');
        } catch (\Throwable $th) {
            Log::info('like post api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
