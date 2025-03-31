<?php

namespace App\Http\Controllers;

use App\Http\Resources\Api\Meeting\MeetingResource;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetMeetingPastController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            $meetings = Meeting::whereHas('participants', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->where(function($query) {
                    $query->whereDate('meeting_date', '<', now()->toDateString())
                        ->orWhere(function($q) {
                            $q->whereDate('meeting_date', '=', now()->toDateString())
                                ->whereTime('meeting_time', '<', now()->toTimeString());
                        });
                })
                ->when($request->user_id, function($query) use ($request) {
                    $query->whereHas('participants', function($q) use ($request) {
                        $q->where('user_id', $request->user_id);
                    });
                })
                ->with(['participants.user'])
                ->orderBy('meeting_date', 'desc')
                ->orderBy('meeting_time', 'desc')
                ->get();

            return MeetingResource::collection($meetings);
        } catch (\Throwable $th) {
            Log::info('get meetingspast api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
