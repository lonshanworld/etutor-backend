<?php

namespace App\Http\Requests\Meeting;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('sanctum')->user()->role_id === 2; // Only allow tutor
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'creator_id' =>'prohibited', 
            'meeting_subject' =>'required|string|max:255',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'meeting_link' => 'required|string',
            'users' => 'required|array|min:1',
            'users.*' => 'required|integer|exists:users,id'
        ];
    }
}
