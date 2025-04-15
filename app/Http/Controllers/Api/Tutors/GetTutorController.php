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
                        $q->where('email', $request->search)
                            ->orWhere('first_name', 'like', $request->search . '%')
                            ->orWhere('middle_name', 'like', $request->search . '%')
                            ->orWhere('last_name', 'like', $request->search . '%');
                    });
                })
                ->when($request->filter, function ($query) use ($request) {
                    switch ($request->filter) {
                        case '0d': // Today
                            $query->whereDate('activity_logs.session_login', Carbon::today())
                                ->where('activity_logs.session_logout', '<', Carbon::now());
                            break;
                        case '7d': // Last 7 days
                            // ->whereColumn('session_login', '<', 'session_logout')
                            $query->whereColumn('activity_logs.session_login', '<', 'activity_logs.session_logout')
                                ->where('activity_logs.session_logout', '<=', Carbon::now()->subDays(7));
                            break;
                        case '28d': // Last 28 days
                            $query->whereColumn('activity_logs.session_login', '<', 'activity_logs.session_logout')
                                ->where('activity_logs.session_logout', '<=', Carbon::now()->subDays(28));
                            break;
                    }
                })
                ->with('activityLog')
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
