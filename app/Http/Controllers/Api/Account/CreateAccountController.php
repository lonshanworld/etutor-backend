<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\CreateUserAccountRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Mail;

class CreateAccountController extends Controller
{
    public function __invoke(CreateUserAccountRequest $createUserAccountRequest)
    {
        try {
            // $user = User::create([
            //     'first_name' => $request->first_name,
            //     'middle_name' => $request->middle_name,
            //     'last_name' => $request->last_name,
            //     'email' => $request->email,
            //     'date_of_birth' => $request->date_of_birth,
            //     'nationality' => $request->nationality,
            //     'gender_id' => $request->gender_id,
            //     'role_id' => $request->role_id,
            //     'password' => Hash::make($request->password),
            //     'password_confirmation' => Hash::make($request->password_confirmation),
            // ]);
            User::create($createUserAccountRequest->validated());
            return response()->success([], 'User account created successfully.', 200);
        } catch (\Throwable $th) {
            return response()->error('An error occurred while creating the account.', 500);
        }
    }
}