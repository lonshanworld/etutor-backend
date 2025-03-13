<?php

namespace App\Http\Controllers\Api\Subjects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Subject\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetSubjectController extends Controller
{
    public function __invoke()
    {
        try {
            return SubjectResource::collection(
                Subject::orderBy('name', 'asc')->get()
            );
        } catch (\Throwable $th) {
            //throw $th;
            Log::info('get subject api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
