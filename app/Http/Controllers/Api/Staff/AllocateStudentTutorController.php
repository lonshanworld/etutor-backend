<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\AllocateStudentTutorRequest;
use App\Models\Student;
use App\Models\TutoringSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AllocateStudentTutorController extends Controller
{
    public function __invoke(AllocateStudentTutorRequest $allocateStudentTutorRequest)
    {
        $validatedData = $allocateStudentTutorRequest->validated();
        try {
            //Check if student is already allocated
            $studentIds = $validatedData['student_id'];
            $tutorId = $validatedData['tutor_id'];
            
            // Check if tutor already has maximum students
            $tutorStudentCount = TutoringSession::where('tutor_id', $tutorId)
                ->distinct('student_id')
                ->count('student_id');
            $remainingSlots = 10 - $tutorStudentCount;
            if ($tutorStudentCount + count($studentIds) > 10) {
                $studentText = $remainingSlots === 1 ? "student" : "students";
                return response()->error(
                    "Tutor already has {$tutorStudentCount} students. Can only allocate {$remainingSlots} more {$studentText}."
                );
            }

            // Check if student is already allocated
            $existingSession = TutoringSession::whereIn('student_id', $studentIds)
                ->where(function ($query) use ($tutorId) {
                    $query->where('tutor_id', $tutorId)
                        ->orWhere('tutor_id', '!=', $tutorId);
                })
                ->first();
            if ($existingSession) {
                $student = Student::find($existingSession->student_id);
                $user = User::find($student->user_id);
                
                $message = "{$user->first_name} {$user->last_name} is already allocated to " . 
                        ($existingSession->tutor_id == $tutorId ? "this tutor" : "another tutor");

                return response()->error($message);
            }

            DB::beginTransaction();
            // Prepare array of records for bulk upsert
            $records = [];
            foreach ($validatedData['student_id'] as $student) {
                $records[] = [
                    'tutor_id' => $validatedData['tutor_id'],
                    'student_id' => $student,
                    'assigned_by' => $allocateStudentTutorRequest->user()->id
                ];
            }
            // Perform bulk upsert - unique bytutor_id, student_id
            TutoringSession::upsert(
                $records, 
                ['tutor_id', 'student_id'], // Unique keys
                ['assigned_by', 'updated_at'] // Columns to update if record exists
            );

            // 1 send to student
            // 2 send to tutor

            // Mail::to($student->email)->send(new AllocateSuccessEmail($message));
            // Mail::to($tutor->email)->send(new AllocateSuccessEmail($message));
            DB::commit();
            
            return response()->success(
                [],
                'Allocated successfully.',
                200
            );
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error('allocate student to tutor', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
