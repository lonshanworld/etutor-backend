<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\DeleteBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeleteBlogController extends Controller
{
    public function __invoke(Blog $blog)
    {
        try {
            if($blog->user_id != auth('sanctum')->id()) {
                return response()->json([
                    'message' => 'not allow'
                ], 403);
            }
            
            // Delete all associated files first
            $blog->files()->delete();
            $blog->delete();
            return response()->success([], 'blog deleted');
        } catch (\Throwable $th) {
            Log::info('blog delete api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
        
    }
}
