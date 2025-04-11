<?php

namespace App\Http\Controllers\Api\Students;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Students\StudentResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetStudentController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $students = User::whereHas('role', function ($query) {
                $query->where('name', 'student');
            })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('email', $request->search)
                          ->orWhere('first_name', 'like', '%' . $request->search . '%')
                          ->orWhere('middle_name', 'like', '%' . $request->search . '%')
                          ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });
                })
                ->with([
                    'student.major',
                    'role',
                    'student.studentTutoringSessions.tutor.user',
                    'student.studentTutoringSessions.student.user',
                    'student.studentTutoringSessions.student.major'
                ])
                ->paginate(config('app.paginate.count'));
            return StudentResource::collection($students);
        } catch (\Throwable $th) {
            Log::info('student api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
