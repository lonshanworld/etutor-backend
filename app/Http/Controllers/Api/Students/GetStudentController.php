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
                        $q->where('email', $request->search) // Exact email match
                        ->orWhere(function($innerQ) use ($request) {
                            $searchTerms = explode(' ', $request->search);
                            $innerQ->where(function($subQuery) use ($searchTerms) {
                                foreach ($searchTerms as $term) {
                                    $subQuery->where('first_name', 'like', '%'.$term.'%')
                                            ->orWhere('middle_name', 'like', '%'.$term.'%')
                                            ->orWhere('last_name', 'like', '%'.$term.'%');
                                }
                            });
                        });
                    });
                })
                ->when($request->filter, function ($query) use ($request) {
                    Log::info('filter', [
                        'filter' => $request->filter
                    ]);

                    // Use leftJoin with activity_logs table to filter properly
                    $query->leftJoin('activity_logs', 'users.id', '=', 'activity_logs.user_id');

                    // Filter users based on activity logs
                    // login today datetime & logout < today datetime
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

                    // Select only users fields to avoid ambiguous column references
                    $query->select('users.*');
                })
                ->with([
                    'activityLog',
                    'student.major',
                    'role',
                    'student.studentTutoringSessions.tutor.user',
                    'student.studentTutoringSessions.student.user',
                    'student.studentTutoringSessions.student.major'
                ])
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
