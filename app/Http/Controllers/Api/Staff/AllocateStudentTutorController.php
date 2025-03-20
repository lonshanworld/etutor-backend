<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\AllocateStudentTutorRequest;
use App\Models\TutoringSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AllocateStudentTutorController extends Controller
{
    public function __invoke(AllocateStudentTutorRequest $allocateStudentTutorRequest)
    {
        $validatedData = $allocateStudentTutorRequest->validated();
        try {
            // Check tutor's student count
            $tutorStudentCount = TutoringSession::where('tutor_id', $validatedData['tutor_id'])->count();
            if ($tutorStudentCount + count($validatedData['student_id']) > 10) {
                return response()->error('Cannot allocate more than 10 students to a tutor');
            }

            // Check if any of the students are already assigned
            foreach ($validatedData['student_id'] as $student) {
                $existingSession = TutoringSession::where('student_id', $student)->exists();
                if ($existingSession) {
                    $studentName = User::find($student)->first_name . ' ' . User::find($student)->last_name;
                    return response()->error($studentName . ' is already assigned to a tutor');
                }
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
            DB::commit();
            return response()->success(
                [],
                'allocated successfully',
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
