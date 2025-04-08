<?php

namespace App\Http\Controllers\Api\TutoringSessions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\StudentInfoResource;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\TutoringSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetStudentsByTutorController extends Controller
{
    public function __invoke(Request $request, string $user_id)
    {
        try {
            $tutor = Tutor::where('user_id', $user_id)->first();
            
            if (!$tutor) {
                return response()->json(['message' => 'Tutor not found'], 404);
            }

            $studentIds = TutoringSession::where('tutor_id', $tutor->id)->pluck('student_id');
            $students = Student::with('user')
                ->whereIn('id', $studentIds)
                ->paginate($request->per_page ?? config('app.paginate.count'));

            return StudentInfoResource::collection($students);
        } catch (\Throwable $th) {
            //throw $th;
            Log::info('get student by tutor', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
