<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\CreateStudentAccountRequest;
use App\Models\Major;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateStudentAccountController extends Controller
{
    public function __invoke(CreateStudentAccountRequest $createStudentAccountRequest)
    {
        try {
            DB::beginTransaction();
            // insert data to users table
            $user = User::create($createStudentAccountRequest->validated());
            $user->role()->associate(3); // for now use static number ***
            $user->save();

            // insert data to student table
            $major = Major::where('id', $createStudentAccountRequest->validated()['major_id'])->first();

            $user->student()->create([
                'major_id' => $createStudentAccountRequest->validated()['major_id'],
                'created_by' => $createStudentAccountRequest->user()->id,
                'updated_by' => $createStudentAccountRequest->user()->id,
                'emergency_contact_name' => $createStudentAccountRequest->validated()['emergency_contact_name'],
                'emergency_contact_phone' => $createStudentAccountRequest->validated()['emergency_contact_phone'],
                'enrollment_date' => Carbon::now(),
                'graduation_date' => Carbon::now()->addYears((int)$major->education_year),
                'current_year' => Carbon::now()
            ]);
            
            DB::commit();
            return response()->success([], 'success', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('create student api', [
                'message' => $th->getMessage()
            ]);
            return response()->error('An error occurred while creating the account.', 500);
        }
    }
}
