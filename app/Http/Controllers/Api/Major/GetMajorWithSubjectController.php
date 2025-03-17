<?php

namespace App\Http\Controllers\Api\Major;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Major\MajorSubjectResource;
use App\Models\Major;
use App\Models\MajorSubject;
use Illuminate\Support\Facades\Log;

class GetMajorWithSubjectController extends Controller
{
    public function __invoke()
    {
        try {
            return MajorSubjectResource::collection(
                MajorSubject::orderBy('major_id', 'asc')->get()
            );
        } catch (\Throwable $th) {
            //throw $th;
        Log::info('get majors-with-subjects api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
