<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\AllocateStudentTutorRequest;
use App\Models\TutoringSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AllocateStudentTutorController extends Controller
{
    public function __invoke(AllocateStudentTutorRequest $allocateStudentTutorRequest)
    {
        $validatedData = $allocateStudentTutorRequest->validated();
        try {
            DB::beginTransaction();
            // Prepare array of records for bulk upsert
            $records = [];
            foreach ($validatedData['student_id'] as $student) {
                $records[] = [
                    'subject_id' => $validatedData['subject_id'],
                    'tutor_id' => $validatedData['tutor_id'],
                    'student_id' => $student,
                    'assigned_by' => $allocateStudentTutorRequest->user()->id
                ];
            }
            // Perform bulk upsert - unique by subject_id, tutor_id, student_id
            TutoringSession::upsert(
                $records, 
                ['subject_id', 'tutor_id', 'student_id'], // Unique keys
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
