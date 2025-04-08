<?php

namespace App\Http\Controllers\Api\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meeting\StoreMeetingRequest;
use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateMeetingController extends Controller
{
    public function __invoke(StoreMeetingRequest $storeMeetingRequest)
    {
        try {
            DB::beginTransaction();
            $validated = $storeMeetingRequest->validated();

            // auto add creator_id to the meeting
            $validated['creator_id'] = auth('sanctum')->user()->id;
            $meeting = Meeting::create([
                'creator_id' => $validated['creator_id'],
                'meeting_subject' => $validated['meeting_subject'],
                'meeting_date' => $validated['meeting_date'],
                'meeting_time' => $validated['meeting_time'],
                'meeting_type' => $validated['meeting_type'],
                'location' => $validated['location'],
                'platform' => $validated['platform'],
                'meeting_link' => $validated['meeting_link']
            ]);
            
            $meeting->participants()->createMany(
                array_map(
                    fn($userId) => ['user_id' => $userId],
                    $validated['users']
                )
            );

            // Load relationships for response
            $meeting->load([
                'creator:id,first_name,last_name,email,profile_picture',
                'participants.user:id,first_name,last_name,email'
            ]);

            DB::commit();

            return response()->json([
                'meetings' => [
                    [
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
                    ]
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('create meeting api', [
                'error' => $th->getMessage(),
                'request' => $storeMeetingRequest->all()
            ]);
            return response()->error();
        }
    }
}
