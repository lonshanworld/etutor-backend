<?php

namespace App\Http\Controllers;

use App\Http\Resources\Api\TutoringSessions\TutoringSessionResource;
use App\Models\TutoringSession;
use Illuminate\Support\Facades\Log;

class GetTutoringSessionController extends Controller
{
    public function __invoke()
    {
        try {
            $sessions = TutoringSession::with(['tutor', 'student', 'assignedBy'])
                ->orderBy('created_at', 'desc')
                ->get();

            return TutoringSessionResource::collection($sessions);
        } catch (\Throwable $th) {
            Log::error('get tutoring sessions', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
