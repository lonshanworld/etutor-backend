<?php

namespace App\Http\Controllers\Api\Students;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Students\StudentResource;
use Illuminate\Http\Request;

class GetStudentController extends Controller
{
    public function __invoke()
    {
        try {
            return StudentResource::collection([]);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
