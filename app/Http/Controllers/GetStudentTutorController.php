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
                // ->when($request->email, function ($query) use ($request) {
                //     $query->where('email', $request->email);
                // })
                ->with(['student', 'tutor', 'role'])
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
                    // Join with activity_logs table to filter properly
                    $query->leftJoin('activity_logs', 'users.id', '=', 'activity_logs.user_id');
                    
                    // Filter users based on activity logs (each user has only one activity log)
                    switch ($request->filter) {
                        case '0d': // Today
                            $query->whereDate('activity_logs.session_login', Carbon::today())
                                ->where('activity_logs.session_logout', '<', Carbon::now());
                            break;
                        case '7d': // Last 7 days
                            $query->whereColumn('activity_logs.session_login', '<', 'activity_logs.session_logout')
                                ->where('activity_logs.session_logout', '<=', Carbon::now()->subDays(7));
                            break;
                        case '28d': // Last 28 days
                            $query->whereColumn('activity_logs.session_login', '<', 'activity_logs.session_logout')
                                ->where('activity_logs.session_logout', '<=', Carbon::now()->subDays(28));
                            break;
                    }
                    
                    // Prevent duplicate results after joining
                    $query->select('users.*');
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
