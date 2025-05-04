<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Students\StudentResource;
use App\Models\User;
use App\Models\TutoringSession;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class GetStudentUnassignedController extends Controller
{
    public function __invoke(Request $request)
    {
        $allStudents = User::whereHas('role', function($query) {
            $query->where('name', 'student');
        })->pluck('id')->toArray();
        
        $assignedStudentIds = TutoringSession::with('student')
            ->get()
            ->pluck('student.user_id')
            ->filter()
            ->toArray();
            
        $unassignedStudents = User::whereIn('id', array_diff($allStudents, $assignedStudentIds))
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('email', $request->search) // Exact email match
                    ->orWhere(function($innerQ) use ($request) {
                        $searchTerms = explode(' ', $request->search);
                        $innerQ->where(function($subQuery) use ($searchTerms) {
                            foreach ($searchTerms as $term) {
                                $subQuery->where('first_name', 'like', '%'.$term.'%')
                                        ->orWhere('middle_name', 'like', '%'.$term.'%')
                                        ->orWhere('last_name', 'like', '%'.$term.'%');
                            }
                        });
                    });
                });
            })
            ->orderBy('first_name')
            ->orderBy('middle_name')
            ->orderBy('last_name')
            ->paginate(config('app.paginate.count'));
            
        return StudentResource::collection($unassignedStudents);
    }
}