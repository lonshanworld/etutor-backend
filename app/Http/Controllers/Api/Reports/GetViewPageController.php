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
}
