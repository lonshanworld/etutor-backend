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

    public function increaseBrowserCount(Request $request)
    {
        $browserName = strtolower($request->query('name'));
        if (!$browserName) {
            return response()->json(['message' => 'Browser name is required'], 400);
        }

        try {
            $browser = WebBrowser::firstOrCreate(
                ['name' => $browserName],
                ['usage_count' => 0]
            );

            $browser->increment('usage_count');

            return response()->json([
                'message' => 'Browser usage count updated',
                'browser' => $browser
            ]);
        } catch (\Throwable $th) {
            Log::error('Error updating browser usage', [
                'name' => $browserName,
                'message' => $th->getMessage()
            ]);

            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

}
