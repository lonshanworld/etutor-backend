<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
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
                        'url_link' => $attachment
                    ]);
                }
            }
            DB::commit();
            return response()->success();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('create blog api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
