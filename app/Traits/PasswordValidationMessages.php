<?php

namespace App\Traits;

trait PasswordValidationMessages
{
    public function messages(): array
    {
        return [
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must not be greater than 20 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password_confirmation.required_with' => 'The password confirmation field is required.',
            'password_confirmation.min' => 'The password confirmation must be at least 8 characters.',
            'password_confirmation.max' => 'The password confirmation must not be greater than 20 characters.',
            'password_confirmation.regex' => 'The password confirmation must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }
}