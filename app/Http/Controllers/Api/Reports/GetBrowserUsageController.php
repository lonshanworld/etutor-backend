<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BrowserUsage\BrowserUsageResource;
use App\Models\WebBrowser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetBrowserUsageController extends Controller
{
    public function __invoke()
    {
        try {
            return BrowserUsageResource::collection(WebBrowser::orderBy('usage_count', 'desc')->get());
        } catch (\Throwable $th) {
            Log::info('get browser usage api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
