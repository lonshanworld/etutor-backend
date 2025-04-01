<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Repositories\TutoringSession\TutoringSessionRepository;
use App\Http\Resources\Api\Blogs\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetBlogController extends Controller
{
    public function __invoke(Request $request, TutoringSessionRepository $tutoringSessionRepository)
    {
        try {

            $myTutoringSession = $tutoringSessionRepository->getTutoringSessionByStudentId(auth('sanctum')->user()->id);
            if (!$myTutoringSession) {
                return response()->json([
                    'data' => []
                ]);
            }
            $userIds = $tutoringSessionRepository->getUserIdsByTutorId($myTutoringSession->tutor_id);

            return BlogResource::collection(Blog::whereIn('user_id', $userIds)
                ->orWhere('user_id', auth('sanctum')->user()->id)
                ->orderBy('created_at', 'desc')
                ->with(['files', 'author', 'likes.user', 'comments.user'])
                ->paginate($request->per_page ?? config('app.paginate.count')));
        } catch (\Throwable $th) {
            Log::error('get blog api', [
                'data' => $th->getMessage(),
            ]);
            return response()->error();
        }
    }
}
