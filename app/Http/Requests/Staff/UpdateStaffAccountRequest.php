<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffAccountRequest extends FormRequest
{
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
            'first_name' => 'nullable|string|min:2|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->route('id'))
            ],
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:255',
            'gender' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'passport' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|max:20|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/|confirmed',
            'password_confirmation' => 'nullable|string|min:8|max:20|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/|required_with:password',
            'profile_picture' => 'nullable|image',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'start_date' => 'nullable|date'
        ];
    }
}
