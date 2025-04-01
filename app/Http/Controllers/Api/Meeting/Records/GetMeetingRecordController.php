<?php

namespace App\Http\Controllers\Api\Meeting\Records;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Record\RecordResource;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetMeetingRecordController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $records = Record::with('meeting')->when($request->id, function ($query) use ($request) {
                return $query->where('meeting_id', $request->id);
            })->paginate($request->per_page ?? config('app.paginate.count'));
           
            return RecordResource::collection($records);

        } catch (\Throwable $th) {
            Log::info('get record api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
