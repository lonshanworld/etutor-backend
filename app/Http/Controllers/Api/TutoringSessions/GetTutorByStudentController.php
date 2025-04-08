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
            
            $tutorIds = TutoringSession::where('student_id', $student->id)->pluck('tutor_id');
            $tutors = Tutor::with('user')
                ->whereIn('id', $tutorIds)
                ->paginate($request->per_page ?? config('app.paginate.count'));

            return TutorInfoResource::collection($tutors);
        } catch (\Throwable $th) {
            Log::error('get tutor by student', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
