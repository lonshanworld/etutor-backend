<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\AllocateStudentTutorRequest;
use Illuminate\Http\Request;

class AllocateStudentTutorController extends Controller
{
    public function __invoke(AllocateStudentTutorRequest $allocateStudentTutorRequest)
    {
        dd(
            $allocateStudentTutorRequest->validated()
        );
    }
}
