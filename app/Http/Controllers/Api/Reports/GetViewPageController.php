<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetViewPageController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            return response()->json([
                'data' => Page::orderBy('view_count', 'desc')->get()
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::info('view page report api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }

    public function increasePageCount(Request $request)
    {
        $route = strtolower($request->query('route'));

        if (!$route) {
            return response()->json(['message' => 'Route query is required'], 400);
        }

        try {
            $page = Page::firstOrCreate(
                ['url' => $route],
                ['view_count' => 0]
            );

            $page->increment('view_count');

            return response()->json([
                'message' => 'Page view count updated successfully',
                'page' => $page
            ]);
        } catch (\Throwable $th) {
            Log::error('Error updating view count', [
                'route' => $route,
                'error' => $th->getMessage(),
            ]);

            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }
}
