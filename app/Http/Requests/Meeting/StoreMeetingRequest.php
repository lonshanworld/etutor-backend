<?php

namespace App\Http\Requests\Meeting;

use App\Enums\MeetingType;
use App\Enums\PlatformType;
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
            'meeting_type' => ['required', 'string', 'in:' . implode(',', array_column(MeetingType::cases(), 'value'))],
            'location' => 'nullable|string|max:255',
            'platform' => ['nullable', 'string', 'max:255', 'in:' . implode(',', array_column(PlatformType::cases(), 'value'))],
            'meeting_link' => 'nullable|string',
            'users' => 'required|array|min:1',
            'users.*' => 'required|integer|exists:users,id'
        ];
    }
    
    public function messages(): array
    {
        return [
            'meeting_type.in' => 'The meeting type must be one of: ' . implode(', ', array_column(MeetingType::cases(), 'value')),
            'platform.in' => 'The platform must be one of: ' . implode(', ', array_column(PlatformType::cases(), 'value'))
        ];
    }
}