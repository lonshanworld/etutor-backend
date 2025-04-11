<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Blogs\BlogResource;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetBlogByIdController extends Controller
{
    public function __invoke(string $id)
    {
        try {
            $blog = Blog::with(['files', 'likes', 'comments.user'])
                ->whereNull('deleted_at')
                ->findOrFail($id);
            return new BlogResource($blog);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found'
            ], 404);
        } catch (\Throwable $th) {
            //throw $th;
            Log::info('get blog by id api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
