<?php

namespace App\Http\Controllers;

use App\Http\Resources\Api\Students\StudentResource;
use App\Http\Resources\Api\Tutors\TutorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetStudentTutorController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $users = User::whereHas('role', function ($query) {
                $query->whereIn('name', ['student', 'tutor']);
            })
            ->when($request->email, function($query) use($request) {
                $query->where('email', $request->email);
            })
            ->with(['student', 'tutor', 'role'])
            ->when($request->name, function($query) use($request) {
                $query->where(function($q) use($request) {
                    $q->where('first_name', 'like', '%'.$request->name.'%')
                      ->orWhere('middle_name', 'like', '%'.$request->name.'%')
                      ->orWhere('last_name', 'like', '%'.$request->name.'%');
                });
            })
            ->orderBy('first_name')
            ->orderBy('middle_name')
            ->orderBy('last_name')
            ->paginate(config('app.paginate.count'));

            return response()->json([
                'users' => $users->map(function($user) {
                    if ($user->role->name === 'student' && $user->student) {
                        $user->load('student.studentTutoringSessions');
                        return new StudentResource($user);
                    } elseif ($user->role->name === 'tutor' && $user->tutor) {
                        $user->load('tutor.tutoringSessions');
                        return new TutorResource($user);
                    }
                    return null;
                })->filter()
            ]);
        } catch (\Throwable $th) {
            Log::error('Error fetching users', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
