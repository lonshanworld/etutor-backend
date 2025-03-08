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
                ->when($request->name, function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->name . '%')
                        ->orWhere('middle_name', 'like', '%' . $request->name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->name . '%');
                })
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
