<?php

namespace App\Http\Controllers\Api\TutoringSessions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\StudentInfoResource;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\TutoringSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;

class GetStudentsByTutorController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $authUser = auth('sanctum')->user();
            if (!$authUser) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            
            // Get tutor_id from request or use authenticated user's id
            $tutorId = $request->input('user_id', $authUser->id);
            $tutor = Tutor::where('user_id', $tutorId)->first();
            
            if (!$tutor) {
                return response()->json(['message' => 'Tutor not found'], 404);
            }
            
            $studentIds = TutoringSession::where('tutor_id', $tutor->id)->pluck('student_id');
            $students = Student::with('user')
                ->whereIn('id', $studentIds)
                ->get();


            return StudentInfoResource::collection($students);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('get student by tutor', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
