<?php

namespace App\Http\Requests;

use App\Enums\MeetingType;
use App\Enums\PlatformType;
use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meeting_type' => ['required', 'string', 'in:' . implode(',', array_column(MeetingType::cases(), 'value'))],
            'platform' => ['required_if:meeting_type,virtual', 'string', 'in:' . implode(',', array_column(PlatformType::cases(), 'value')), 'nullable_if:meeting_type,In-Person'],
        ];
    }

    public function messages(): array
    {
        return [
            'meeting_type.in' => 'The meeting type must be one of: ' . implode(', ', array_column(MeetingType::cases(), 'value')),
            'platform.in' => 'The platform must be one of: ' . implode(', ', array_column(PlatformType::cases(), 'value')),
        ];
    }
}