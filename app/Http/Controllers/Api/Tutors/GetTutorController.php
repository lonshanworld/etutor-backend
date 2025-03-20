<?php

namespace App\Http\Controllers\Api\Tutors;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Tutors\TutorResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetTutorController extends Controller
{
    public function __invoke(Request $request)
    {
        // tutor_id
        // student_id
        // user has many tutoring sessions through student table
        try {
            $tutors = User::whereHas('role', function ($query) {
                $query->where('name', 'tutor');
            })       
            ->with(['tutor', 'role', 'tutor.tutoringSessions'])
            ->when($request->name, function($query) use($request) {
                $query->where('first_name', 'like', '%'.$request->name.'%')
                    ->orWhere('middle_name', 'like', '%'.$request->name.'%')
                    ->orWhere('last_name', 'like', '%'.$request->name.'%');
            })
            ->paginate(config('app.paginate.count'));

            return TutorResource::collection($tutors);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
