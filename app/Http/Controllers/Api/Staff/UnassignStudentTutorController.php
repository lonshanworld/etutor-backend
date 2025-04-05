<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UnassignStudentTutorRequest;
use App\Models\TutoringSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Allocation\UnassignSuccessMail;
use App\Notifications\User\UnsignStudentTutorNotification;
use Illuminate\Notifications\Notification;

class UnassignStudentTutorController extends Controller
{
    public function __invoke(UnassignStudentTutorRequest $unassignStudentTutorRequest)
    {
        try {
            DB::beginTransaction();

            // Get tutoring sessions before deletion to access relationships
            $sessions = TutoringSession::whereIn('student_id', $unassignStudentTutorRequest->student_id)
                ->with(['student.user', 'tutor.user'])
                ->get();

            // Group students by tutor for tutor notifications
            $tutorStudents = $sessions->groupBy('tutor_id');

            // Send emails before deletion
            foreach ($tutorStudents as $tutorId => $tutorSessions) {
                $tutor = $tutorSessions->first()->tutor->user;
                $students = $tutorSessions->map(function($session) {
                    return $session->student->user;
                });
                Mail::to($tutor->email)->send(new UnassignSuccessMail($students, $tutor));

                // Send emails to each student
                foreach ($students as $student) {
                    $student->notify(new UnsignStudentTutorNotification($tutor));
                    Mail::to($student->email)->send(new UnassignSuccessMail($student, $tutor));
                }
            }

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