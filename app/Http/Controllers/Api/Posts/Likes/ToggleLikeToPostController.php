<?php

namespace App\Http\Controllers\Api\Posts\Likes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Like\StoreLikeRequest;
use Illuminate\Support\Facades\Log;

class ToggleLikeToPostController extends Controller
{
    public function __invoke(StoreLikeRequest $storeLikeRequest)
    {
        try {
            $validated = $storeLikeRequest->validated();
            $user = auth('sanctum')->user();
            $post = $user->posts()->where('id', $validated['post_id'])->first();
            if ($post->likes()->where('user_id', $validated['user_id'])->exists()) {
                $post->likes()->where('user_id', $validated['user_id'])->delete();
                return response()->success();
            }
            $post->likes()->create([
                'user_id' => $validated['user_id']
            ]);
            return response()->success();
        } catch (\Throwable $th) {
            Log::info('like post api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
