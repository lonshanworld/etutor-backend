<?php

namespace App\Http\Controllers\Api\Students;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Students\StudentResource;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GetStudentController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $students = User::whereHas('role', function ($query) {
                $query->where('name', 'student');
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
                ->with([
                    'student.major',
                    'role',
                    'student.studentTutoringSessions.tutor.user',
                    'student.studentTutoringSessions.student.user',
                    'student.studentTutoringSessions.student.major'
                ])
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
                ->when($request->name, function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->name . '%')
                        ->orWhere('middle_name', 'like', '%' . $request->name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->name . '%');
                })
                ->paginate(config('app.paginate.count'));
            return StudentResource::collection($students);
        } catch (\Throwable $th) {
            Log::info('student api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
