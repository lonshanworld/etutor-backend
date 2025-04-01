<?php

namespace App\Http\Controllers\Api\Meeting;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetRecentMeetingController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            $currentDate = now()->format('Y-m-d');
            $currentTime = now()->format('H:i:s');

            $meetings = Meeting::whereHas('participants', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->where(function($query) use ($currentDate, $currentTime) {
                    $query->where('meeting_date', '<', $currentDate)
                        ->orWhere(function($q) use ($currentDate, $currentTime) {
                            $q->where('meeting_date', $currentDate)
                                ->where('meeting_time', '<', now()->subHour()->format('H:i:s'));
                        });
                })
                ->with([
                    'creator:id,first_name,last_name,email,profile_picture',
                    'participants.user:id,first_name,last_name,email'
                ])
                ->select([
                    'id',
                    'creator_id',
                    'meeting_subject',
                    'meeting_date',
                    'meeting_time',
                    'meeting_type',
                    'location',
                    'platform',
                    'meeting_link'
                ])
                ->orderBy('meeting_date', 'desc')
                ->orderBy('meeting_time', 'desc')
                ->get();

            return response()->json([
                'meetings' => $meetings->map(function($meeting) use ($user) {
                    return [
                        'id' => $meeting->id,
                        'creator_id' => $meeting->creator_id,
                        'subject' => $meeting->meeting_subject,
                        'date' => $meeting->meeting_date,
                        'time' => $meeting->meeting_time,
                        'type' => $meeting->meeting_type,
                        'location' => $meeting->location,
                        'platform' => $meeting->platform,
                        'link' => $meeting->meeting_link,
                        'creator' => [
                            'id' => $meeting->creator->id,
                            'name' => $meeting->creator->first_name . ' ' . $meeting->creator->last_name,
                            'email' => $meeting->creator->email,
                            'profile_picture' => $meeting->creator->profile_picture
                        ],
                        'participants' => $meeting->participants->map(function($participant) {
                            return [
                                'id' => $participant->user->id,
                                'name' => $participant->user->first_name . ' ' . $participant->user->last_name,
                                'email' => $participant->user->email
                            ];
                        })
                    ];
                })
            ]);
        } catch (\Throwable $th) {
            Log::info('get meetings recent api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
