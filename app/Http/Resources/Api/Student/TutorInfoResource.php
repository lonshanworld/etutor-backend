<?php

namespace App\Http\Resources\Api\Student;

use App\Http\Resources\Api\Roles\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user->id,
            'first_name' => $this->user->first_name,
            'middle_name' => $this->user->middle_name,
            'last_name' => $this->user->last_name,
            'profile_picture' => $this->user->profile_picture,
            'subject' => $this->subject_id,
            'qualification' => $this->qualifications,
            'start_date' => $this->created_at,
            'experience' => $this->experience,
            'email' => $this->user->email,
            'phone_number' => $this->user->phone_number,
            'role' => new RoleResource($this->user->role),
            'gender' => $this->user->gender
        ];
    }
}

