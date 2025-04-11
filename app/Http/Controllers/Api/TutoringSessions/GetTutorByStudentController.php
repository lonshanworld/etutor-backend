<?php

namespace App\Http\Controllers\Api\TutoringSessions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\TutorInfoResource;
use App\Http\Resources\Api\Tutors\TutorResource;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\TutoringSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetTutorByStudentController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $student = Student::where('user_id', auth('sanctum')->user()->id)->first();
            
            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }
            
            $tutorId = TutoringSession::where('student_id', $student->id)->value('tutor_id');
            $tutor = Tutor::with('user')
                ->where('id', $tutorId)
                ->first();

            if (!$tutor) {
                return response()->json(['message' => 'Tutor not found'], 404);
            }

            return new TutorInfoResource($tutor);
        } catch (\Throwable $th) {
            Log::error('get tutor by student', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
