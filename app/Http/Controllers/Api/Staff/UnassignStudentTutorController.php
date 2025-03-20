<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\AllocateStudentTutorRequest;
use App\Http\Requests\Staff\UnassignStudentTutorRequest;
use App\Models\TutoringSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnassignStudentTutorController extends Controller
{
    public function __invoke(UnassignStudentTutorRequest $unassignStudentTutorRequest)
    {
        try {
            DB::beginTransaction();

            // Delete all tutoring sessions for the specified students
            TutoringSession::whereIn('student_id', $unassignStudentTutorRequest->student_id)->delete();

            DB::commit();
            return response()->success(
                [],
                'Unassigned successfully',
                200
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('unassign student from tutor', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}