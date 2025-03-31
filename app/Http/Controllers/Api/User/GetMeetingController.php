<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Meeting\MeetingResource;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetMeetingController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            $meetings = Meeting::whereHas('participants', function($query) use ($user) {
                    $query->where('user_id', $user->id);
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
            Log::info('get meetings api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}