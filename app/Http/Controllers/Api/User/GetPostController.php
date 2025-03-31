<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Repositories\TutoringSession\TutoringSessionRepository;
use App\Http\Resources\Api\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetPostController extends Controller
{
    public function __invoke(Request $request, TutoringSessionRepository $tutoringSessionRepository)
    {
        try {

            $myTutoringSession = $tutoringSessionRepository->getTutoringSessionByStudentId(auth('sanctum')->user()->id);
            if(!$myTutoringSession) {
                return response()->json([
                    'data' => []
                ]);
            }
            $userIds = $tutoringSessionRepository->getUserIdsByTutorId($myTutoringSession->tutor_id);
            
            return PostResource::collection(Post::whereIn('user_id', $userIds)
            ->orWhere('user_id', auth('sanctum')->user()->id)
            ->orderBy('created_at', 'desc')
            ->with(['files', 'author', 'likes.user', 'comments.user'])
            ->get());
        } catch (\Throwable $th) {
            Log::error('get post api', [
                'data' => $th->getMessage(),
            ]);
            return response()->error();
        }
    }
}
