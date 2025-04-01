<?php

namespace App\Http\Controllers\Api\Meeting\Records;

use App\Http\Controllers\Controller;
use App\Http\Requests\Record\StoreRecordRequest;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreateMeetingRecordController extends Controller
{
    public function __invoke(StoreRecordRequest $storeRecordRequest)
    {
        try {
            $validated = $storeRecordRequest->validated();
            $record = Record::create($validated);
            return response()->success([
                'status' => true,
            ], 'Record created successfully');
        } catch (\Throwable $th) {
            Log::info('create record api', [
                'message' => $th->getMessage()
            ]);
            return response()->error($th->getMessage(), 500);
        }
    }
}
