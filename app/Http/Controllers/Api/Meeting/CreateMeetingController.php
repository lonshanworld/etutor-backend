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
            $meeting = Meeting::create($validated);
            
            $meeting->participants()->createMany(
                array_map(
                    fn($userId) => ['user_id' => $userId],
                    $validated['users']
                )
            );

            DB::commit();

            return response()->json([
                'message' => 'Meeting created successfully',
                'meeting' => $meeting
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
