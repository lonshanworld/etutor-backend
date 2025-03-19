<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\PasswordValidationMessages;

class UpdatePasswordRequest extends FormRequest
{
    use PasswordValidationMessages;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|max:20|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/|confirmed',
            'password_confirmation' => 'required|string|min:8|max:20|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/|required_with:password',
            'otp' => 'required|numeric'
        ];
    }
}
