<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\CreateTutorAccountRequest;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateTutorAccountController extends Controller
{
    public function __invoke(CreateTutorAccountRequest $createTutorAccountRequest)
    {
        try{
            DB::beginTransaction();
            // insert data to users table
            $user = User::create($createTutorAccountRequest->validated());
            $user->role()->associate(2); // for now use static number **
            $user->save();
            
            // insert data to tutor table
            $user->tutor()->create([
                'qualifications' => $createTutorAccountRequest->validated()['qualifications'],
                'experience' => $createTutorAccountRequest->validated()['experience'],
                'created_by' => $createTutorAccountRequest->user()->id,
                'updated_by' => $createTutorAccountRequest->user()->id
            ]);
            DB::commit();
            return response()->success([], 'success', 200);
        }catch(\Throwable $th){
            DB::rollBack();
            Log::info('create tutor api', [
                'message' => $th->getMessage()
            ]);
            return response()->error('An error occurred while creating the account.', 500);
        }
    }
}
