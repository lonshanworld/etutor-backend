<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostResource;
use Illuminate\Http\Request;

class GetPostController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            return PostResource::collection(auth('sanctum')->user()->posts->load(['files']));
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
