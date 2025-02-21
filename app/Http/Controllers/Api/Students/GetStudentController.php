<?php

namespace App\Http\Controllers\Api\Students;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Students\StudentResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetStudentController extends Controller
{
    public function __invoke()
    {
        try {
            $students = User::whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })->paginate(config('app.paginate.count'));

            return StudentResource::collection($students);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
