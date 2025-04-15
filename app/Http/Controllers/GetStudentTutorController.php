<?php

namespace App\Http\Controllers;

use App\Http\Resources\Api\Students\StudentResource;
use App\Http\Resources\Api\Tutors\TutorResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetStudentTutorController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $users = User::whereHas('role', function ($query) {
                $query->whereIn('name', ['student', 'tutor']);
            })
                ->when($request->email, function ($query) use ($request) {
                    $query->where('email', $request->email);
                })
                ->with(['student', 'tutor', 'role'])
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
                ->orderBy('first_name')
                ->orderBy('middle_name')
                ->orderBy('last_name')
                ->paginate(config('app.paginate.count'));

            return response()->json([
                'users' => $users->map(function ($user) {
                    if ($user->role->name === 'student' && $user->student) {
                        $user->load('student.studentTutoringSessions');
                        return new StudentResource($user);
                    } elseif ($user->role->name === 'tutor' && $user->tutor) {
                        $user->load('tutor.tutoringSessions');
                        return new TutorResource($user);
                    }
                    return null;
                })->filter(),
                'meta' => [
                    'current_page' => $users->currentPage(),
                    'from' => $users->firstItem(),
                    'last_page' => $users->lastPage(),
                    'links' => $users->linkCollection()->toArray(),
                    'path' => $users->path(),
                    'per_page' => $users->perPage(),
                    'to' => $users->lastItem(),
                    'total' => $users->total()
                ]
            ]);
        } catch (\Throwable $th) {
            Log::error('Error fetching users', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
