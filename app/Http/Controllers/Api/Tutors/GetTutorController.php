<?php

namespace App\Http\Controllers\Api\Tutors;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Tutors\TutorResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetTutorController extends Controller
{
    public function __invoke(Request $request)
    {
        // tutor_id
        // student_id
        // user has many tutoring sessions through student table
        try {
            $tutors = User::whereHas('role', function ($query) {
                $query->where('name', 'tutor');
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('email', 'like', '%' . $request->search . '%')
                      ->orWhere('first_name', 'like', '%' . $request->search . '%')
                      ->orWhere('middle_name', 'like', '%' . $request->search . '%')
                      ->orWhere('last_name', 'like', '%' . $request->search . '%');
                });
            })
            ->with(['tutor', 'role', 'tutor.tutoringSessions'])
            ->with([
                'tutor.tutoringSessions.tutor.user',
                'tutor.tutoringSessions.student.user',
                'tutor.tutoringSessions.student.major'
            ])
            ->paginate(config('app.paginate.count'));

            return TutorResource::collection($tutors);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
