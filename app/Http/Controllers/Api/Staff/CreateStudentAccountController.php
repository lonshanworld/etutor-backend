<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\CreateUserAccountRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreateStudentAccountController extends Controller
{
    public function __invoke(CreateUserAccountRequest $createUserAccountRequest)
    {
        try {
            $user = User::create($createUserAccountRequest->validated());
            $user->role()->associate(3); // for now use static number ***
            $user->save();
            return response()->success([], 'success', 200);
        } catch (\Throwable $th) {
            Log::info('create student api', [
                'message' => $th->getMessage()
            ]);
            return response()->error('An error occurred while creating the account.', 500);
        }
    }
}
