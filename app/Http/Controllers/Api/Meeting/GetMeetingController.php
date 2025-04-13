<?php

namespace App\Http\Controllers\Api\Meeting;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetMeetingController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                'message' => 'Unauthorized access',
                'error' => 'Authentication required'
            ], 401);
            }

            $request->validate([
                'user_id' => 'required|integer'
            ]);
            
            $searchUser = User::find($request->user_id);
            if (!$searchUser) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

            $searchUserId = $request->user_id;
            $currentDate = now()->format('Y-m-d');
            $currentTime = now()->format('H:i:s');

            // Add debug logging for current user
            Log::info('Current user details', [
                'user_id' => $user->id,
                'search_user_id' => $searchUserId,
                'current_date' => $currentDate,
                'current_time' => $currentTime
            ]);

            // Build the base query
            $query = Meeting::where(function($q) use ($currentDate, $currentTime) {
                    $q->where('meeting_date', '>', $currentDate)
                      ->orWhere(function($q) use ($currentDate, $currentTime) {
                          $q->where('meeting_date', $currentDate)
                            ->where('meeting_time', '>=', $currentTime);
                      });
                })
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
                ])
                ->when($request->id, function($q) use ($request) {
                    return $q->where('id', $request->id);
                })
                ->whereNull('deleted_at');

            // Check user role and modify query accordingly
            $searchUser = User::find($searchUserId);
            if ($searchUser->role->name === 'tutor') {
                $query->where('creator_id', $searchUserId);
            } else {
                $query->whereHas('participants', function($q) use ($searchUserId) {
                    $q->where('user_id', $searchUserId);
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