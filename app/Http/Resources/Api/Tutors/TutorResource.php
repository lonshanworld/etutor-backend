<?php

namespace App\Http\Resources\Api\Tutors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Roles\RoleResource;
use App\Http\Resources\Api\TutoringSessions\TutoringSessionResource;

class TutorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'nationality' => $this->nationality,
            'gender' => $this->gender,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'role' => new RoleResource($this->role),
            'image_id' => $this->image_id,
            'email_verified_at' => $this->email_verified_at, 
            'profile_picture' => $this->profile_picture,
            
            // Include tutor-specific data
            'tutor' => [
                'id' => $this->tutor->id ?? null,
                'subject_id' => $this->tutor->subject_id ?? null,
                'qualifications' => $this->tutor->qualifications ?? null,
                'experience' => $this->tutor->experience ?? null,
            ],

            //tutoring sessions
            'tutoring_sessions' => TutoringSessionResource::collection($this->tutoringSessions),
            'student_counts' => $this->tutoringSessions->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
