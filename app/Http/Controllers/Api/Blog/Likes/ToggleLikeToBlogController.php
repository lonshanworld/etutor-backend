<?php

namespace App\Http\Controllers\Api\Blog\Likes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Like\StoreLikeRequest;
use Illuminate\Support\Facades\Log;

class ToggleLikeToBlogController extends Controller
{
    public function __invoke(StoreLikeRequest $storeLikeRequest)
    {
        try {
            $validated = $storeLikeRequest->validated();
            $user = auth('sanctum')->user();
            $post = $user->blogs()->where('id', $validated['blog_id'])->first();
            if ($post->likes()->where('user_id', $user->id)->exists()) {
                $post->likes()->where('user_id', $user->id)->delete();
                return response()->success();
            }
            $post->likes()->create([
                'user_id' => $user->id
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
