<?php

namespace App\Http\Controllers\Api\Tutors;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Tutors\TutorResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetTutorController extends Controller
{
    public function __invoke()
    {
        try {
            $students = User::whereHas('roles', function ($query) {
                $query->where('name', 'tutor');
            })->paginate(config('app.paginate.count'));

            return TutorResource::collection($students);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
