<?php

namespace App\Http\Repositories\TutoringSession;

use App\Models\Tutor;
use App\Models\TutoringSession;

class TutoringSessionRepository
{
    public function getTutoringSessionByTutorId(string $id)
    {
        return TutoringSession::where('tutor_id', $id)->first();
    }

    public function getTutoringSessionByStudentId(string $id)
    {
        return TutoringSession::where('student_id', $id)->first();
    }

    public function getUserIdsByTutorId(string $id)
    {
        return TutoringSession::where('tutor_id', $id)->pluck('student_id');
    }
}