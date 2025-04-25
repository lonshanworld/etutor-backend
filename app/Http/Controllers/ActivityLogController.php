<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function getLogByUserId(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'user_id is required'], 400);
        }

        $logs = ActivityLog::where('user_id', $userId)->get();

        return response()->json(
            ["data" => $logs]
        );
    }

    /**
     * POST /api/activity-log/session-login?id=1
     * Update session_login time for a given activity log ID
     */
    public function updateSessionLogin(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return response()->json(['message' => 'id is required'], 400);
        }

        $activityLog = ActivityLog::find($id);

        if (!$activityLog) {
            return response()->json(['message' => 'ActivityLog not found'], 404);
        }

        $activityLog->session_login = Carbon::now();
        $activityLog->visit_count += 1;
        $activityLog->save();

        return response()->json(['message' => 'Session login time updated successfully', 'data' => $activityLog]);
    }

    public function updateSessionLogout($id)
    {

        if (!$id) {
            return response()->json(['message' => 'id is required'], 400);
        }

        $activityLog = ActivityLog::find($id);

        if (!$activityLog) {
            return response()->json(['message' => 'ActivityLog not found'], 404);
        }

        $activityLog->session_logout = Carbon::now();
        $activityLog->save();

        return response()->json(['message' => 'Session logout time updated successfully', 'data' => $activityLog]);
    }

    public function updateSessionLogoutReq(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return response()->json(['message' => 'id is required'], 400);
        }

        $activityLog = ActivityLog::find($id);

        if (!$activityLog) {
            return response()->json(['message' => 'ActivityLog not found'], 404);
        }

        $activityLog->session_logout = Carbon::now();
        $activityLog->save();

        return response()->json(['message' => 'Session logout time updated successfully', 'data' => $activityLog]);
    }
}
