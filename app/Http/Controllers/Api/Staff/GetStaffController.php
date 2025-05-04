<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Staff\StaffResource;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GetStaffController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $staffs = User::whereHas('role', function ($query) {
                $query->where('name', 'admin')
                    ->orWhere('name', 'staff');
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
                    $query->leftJoin('activity_logs', 'users.id', '=', 'activity_logs.user_id');
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
                ->paginate(config('app.paginate.count'));

            return StaffResource::collection($staffs);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
