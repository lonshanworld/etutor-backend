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
        $names = collect([$this->user?->first_name, $this->user?->middle_name, $this->user?->last_name])
            ->filter()
            ->join(' ');

        return [
            'user_id' => $this->user?->id,
            'name' => $names,
            'profile_picture' => $this->user?->profile_picture,
            'subject_id' => $this->subject_id,
            'subject_name' => $this->subject?->name,
            'qualification' => $this->qualifications,
            'experience' => $this->experience,
            'email' => $this->user?->email,
            'phone_number' => $this->user?->phone_number,
            'role_id' => $this->user?->role?->id,
            'role_name' => $this->user?->role?->name,
            'gender' => $this->user?->gender
        ];
    }
}

