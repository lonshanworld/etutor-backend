<?php

namespace App\Http\Controllers\Api\Major;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Major\MajorResource;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetMajorController extends Controller
{
    public function __invoke()
    {
        try {
            return MajorResource::collection(
                Major::orderBy('name', 'asc')->get()
            );
        } catch (\Throwable $th) {
            //throw $th;
        Log::info('get majors api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
