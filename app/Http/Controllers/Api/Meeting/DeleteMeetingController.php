<?php

namespace App\Http\Controllers\Api\Meeting;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteMeetingController extends Controller
{
    public function __invoke(Request $request, Meeting $meeting)
    {
        $user = Auth::user();
        $tutorRole = Role::where('name', 'tutor')->first();

        if ($user->role_id !== $tutorRole->id) {
            return response()->json([
                'message' => 'Unauthorized. Only tutors can delete meetings.'
            ], 403);
        }

        if ($meeting->creator_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized. You can only delete your own meetings.'
            ], 403);
        }

        $meeting->delete();

        return response()->json([
            'message' => 'Meeting deleted successfully'
        ]);
    }
}