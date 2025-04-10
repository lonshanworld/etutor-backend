<?php

namespace App\Http\Controllers\Api\Tutors;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Tutors\TutorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
                ->when($request->filter, function ($query) use ($request) {
                    // Filter users based on activity logs (each user has only one activity log)
                    switch ($request->filter) {
                        case '0d': // Today
                            $query->whereHas('activityLog', function ($q) {
                                $q->whereDate('session_login', Carbon::today());
                            });
                            break;
                        case '7d': // Last 7 days
                            $query->whereHas('activityLog', function ($q) {
                                $q->where('session_login', '>=', Carbon::now()->subDays(7));
                            });
                            break;
                        case '28d': // Last 28 days
                            $query->whereHas('activityLog', function ($q) {
                                $q->where('session_login', '>=', Carbon::now()->subDays(28));
                            });
                            break;
                    }
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
