<?php

namespace App\Http\Controllers\Api\Files;

use App\Http\Controllers\Controller;
use App\Http\Repositories\TutoringSession\TutoringSessionRepository;
use App\Http\Resources\Api\Files\FileResource;
use App\Http\Resources\Api\PostResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetFilesController extends Controller
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

            $files = Blog::whereIn('user_id', $userIds)
                ->orWhere('user_id', auth('sanctum')->user()->id)
                ->orderBy('created_at', 'desc')
                ->with(['files', 'author'])
                ->get()
                ->pluck('files')
                ->flatten()
                ->map(function ($file) {
                    return new FileResource($file);
                });

            $perPage = $request->input('per_page', 10);
            $currentPage = $request->input('page', 1);

            $paginatedFiles = new \Illuminate\Pagination\LengthAwarePaginator(
                $files->forPage($currentPage, $perPage),
                $files->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url()]
            );

            return FileResource::collection($paginatedFiles);
            
        } catch (\Throwable $th) {
            Log::error('get files api', [
                'data' => $th->getMessage(),
            ]);
            return response()->error();
        }
    }
}
