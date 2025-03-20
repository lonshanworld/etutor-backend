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
            return TutoringSessionResource::collection(
                TutoringSession::orderBy('tutor_id', 'asc')->get()
            );
        } catch (\Throwable $th) {
            Log::error('get tutoring_sessions api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
