<?php

namespace App\Http\Controllers\Api\Meeting;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetMeetingController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            $currentDate = now()->format('Y-m-d');
            $currentTime = now()->format('H:i:s');

            // Add debug logging for current user
            Log::info('Current user details', [
                'user_id' => $user->id,
                'current_date' => $currentDate,
                'current_time' => $currentTime
            ]);

            // Build the base query
            $query = Meeting::where('meeting_date', '>=', $currentDate)
                ->whereNull('deleted_at')
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
                ]);

            // Filter based on user role
            if ($user->role_id === 2) { // Tutor
                $query->where('creator_id', $user->id);
            } else { // Student
                $query->whereHas('participants', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }

            $query->orderBy('meeting_date', 'asc')
                  ->orderBy('meeting_time', 'asc');
                
            // Add debug logging for participants check
            Log::info('Checking participants table', [
                'participant_count' => Participant::where('user_id', $user->id)->count(),
                'user_id' => $user->id
            ]);

            // Add debug logging for the query
            Log::info('Meeting query SQL', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            $meetings = $query->get();

            // Add debug logging
            Log::info('Meetings query parameters', [
                'date' => $currentDate,
                'time' => $currentTime,
                'user_id' => $user->id,
                'count' => $meetings->count()
            ]);

            return response()->json([
                'meetings' => $meetings->map(function($meeting) use ($user) {
                    return [
                        'id' => $meeting->id,
                        'creator_id' => $meeting->creator_id,
                        'subject' => $meeting->meeting_subject,
                        'date' => $meeting->meeting_date,
                        'time' => $meeting->meeting_time,
                        // Convert meeting_type to string value to avoid enum issues
                        'type' => $meeting->meeting_type?->value ?? $meeting->meeting_type,
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
            Log::info('get meetings api', [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString() // Add stack trace for better debugging
            ]);
            return response()->error();
        }
    }
}