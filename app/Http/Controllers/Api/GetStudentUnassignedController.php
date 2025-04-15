<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Students\StudentResource;
use App\Models\User;
use App\Models\TutoringSession;
use Illuminate\Http\Response;

class GetStudentUnassignedController extends Controller
{
    public function __invoke()
    {
        $allStudents = User::whereHas('role', function($query) {
            $query->where('id', 3);
        })->pluck('id')->toArray();
        
        $assignedStudentIds = TutoringSession::with('student')
            ->get()
            ->pluck('student.user_id')
            ->filter()
            ->toArray();
            
        $unassignedStudents = User::whereIn('id', array_diff($allStudents, $assignedStudentIds))
            ->orderBy('first_name')
            ->orderBy('middle_name')
            ->orderBy('last_name')
            ->paginate(config('app.paginate.count'));
            
        return StudentResource::collection($unassignedStudents);
    }
}