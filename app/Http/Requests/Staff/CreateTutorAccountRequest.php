<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\PasswordValidationMessages;

class CreateTutorAccountRequest extends FormRequest
{
    use PasswordValidationMessages;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'gender' => 'required|string',
            'address' =>'required|string',
            'phone_number' =>'required|string|max:20',
            'password' => 'required|string|min:8|max:20|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/|confirmed',
            'password_confirmation' => 'required|string|min:8|max:20|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/|required_with:password',
            'subject_id' => 'required|integer',
            'qualifications' => 'required|string',
            'experience' => 'required|integer'
        ];
    }
}
