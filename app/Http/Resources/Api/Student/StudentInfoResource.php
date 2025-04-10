<?php

namespace App\Http\Resources\Api\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $names = collect([
            $this->user->first_name,
            $this->user->middle_name,
            $this->user->last_name
        ])->filter()->join(' ');

        return [
            'user_id' => $this->user->id,
            'name' => $names,
            'profile_picture' => $this->user->profile_picture,
            'email' => $this->user->email,
            'phone_number' => $this->user->phone_number
        ];
    }
}
