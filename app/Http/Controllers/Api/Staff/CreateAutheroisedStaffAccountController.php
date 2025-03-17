<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\CreateAuthorizedStaffAccountRequest;
use App\Http\Requests\Staff\CreateTutorAccountRequest;
//use App\Http\Requests\Staff\Create;
use App\Models\AuthorizedStaff;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class CreateAutheroisedStaffAccountController extends Controller
{
    public function __invoke(CreateAuthorizedStaffAccountRequest $createAuthorizedStaffAccountRequest)
    {
        try {
            DB::beginTransaction();
            // insert data to users table
            $user = User::create($createAuthorizedStaffAccountRequest->validated());
            $user->role()->associate(1); // for now use static number ***
            $user->save();

            $user->staff()->create([
                'created_by' => $createAuthorizedStaffAccountRequest->user()->id,
                'updated_by' => $createAuthorizedStaffAccountRequest->user()->id,
                'emergency_contact_name' => $createAuthorizedStaffAccountRequest->validated()['emergency_contact_name'],
                'emergency_contact_phone' => $createAuthorizedStaffAccountRequest->validated()['emergency_contact_phone'],
                'start_date' => Carbon::now(),
                'end_date' => null           
            ]);
            DB::commit();
            return response()->success([], 'success', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('create staff api', [
                'message' => $th->getMessage()
            ]);
            return response()->error('An error occurred while creating the account.', 500);
        }
    }
}
