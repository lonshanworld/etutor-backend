<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\AllocateStudentTutorRequest;
use App\Models\TutoringSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllocateStudentTutorController extends Controller
{
    public function __invoke(AllocateStudentTutorRequest $allocateStudentTutorRequest)
    {

        // {
        //     "subject_id" : 1,
        //     "student_id" : [1,2,3,4,5],
        //     "tutor_id" : 1
        // }

        dd(
            $allocateStudentTutorRequest->validated()
        );
        try {
            DB::beginTransaction();
            foreach ($allo as $key => $value) {
                # code...
            }
            TutoringSession::create();
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }
}
