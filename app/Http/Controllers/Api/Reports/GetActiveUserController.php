<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ActivityLog\ActivityLogResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetActiveUserController extends Controller
{
    public function __invoke()
    {
        try {
            return ActivityLogResource::collection(ActivityLog::with('user')
            ->orderBy('visit_count', 'desc')
            ->paginate($request->per_page ?? config('app.paginate.count'))->withQueryString());
        } catch (\Throwable $th) {
            Log::info('get active user api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
