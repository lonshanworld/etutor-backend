<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAccountController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'date_of_birth' => 'required|date',
                'nationality' => 'required|string|max:255',
                'gender_id' => 'required|integer|exists:genders,id',
                'role_id' => 'required|integer|exists:roles,id',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->error($validator->errors()->first(), 422);
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'nationality' => $request->nationality,
                'gender_id' => $request->gender_id,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
            ]);

            return response()->success($user, 'User account created successfully.', 201);
        } catch (\Throwable $th) {
            return response()->error('An error occurred while creating the account.', 500);
        }
    }
}
