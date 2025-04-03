<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
use App\Http\Resources\Api\Blogs\BlogResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateBlogController extends Controller
{
    public function __invoke(CreateBlogRequest $createBlogRequest)
    {
        try {
            DB::beginTransaction();
            $validatedData = $createBlogRequest->validated();
            $validatedData['url_link'] = [];
            $createBlog = auth('sanctum')->user()->blogs()->create($validatedData);
            if ($createBlogRequest->has('attachments')) {
                foreach ($createBlogRequest->validated('attachments') as $attachment) {
                    $createBlog->files()->create([
                        'file_name' => $attachment['name'],
                        'url_link' => $attachment['path']
                    ]);
                }
            }
            DB::commit();
            $refreshBlog = $createBlog->refresh();
            return response()->success([
                'blog' => new BlogResource($refreshBlog->load('files', 'likes', 'comments', 'author'))
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('create blog api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
