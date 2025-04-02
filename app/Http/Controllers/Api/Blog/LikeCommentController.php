<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Blogs\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class LikeCommentController extends Controller
{
    public function __invoke(string $id)
    {
        try {
            return new BlogResource(Blog::with(['files', 'likes', 'comments'])->where('id', $id)->firstOrFail());
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}