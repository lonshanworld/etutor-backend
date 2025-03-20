<?php

namespace App\Http\Resources\Api\Students;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Roles\RoleResource;
use App\Http\Resources\Api\TutoringSessions\TutoringSessionResource;
use App\Models\Student;

class StudentResource extends JsonResource
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

            // Include student-specific data
            'student' => [
                'id' => $this->student->id ?? null,
                'major_id' => $this->student->major_id ?? null,
                'emergency_contact_name' => $this->student->emergency_contact_name ?? null,
                'emergency_contact_phone' => $this->student->emergency_contact_phone ?? null,
                'enrollment_date' => $this->student->enrollment_date ?? null,
                'graduation_date' => $this->student->graduation_date ?? null,
                'current_year' => $this->student->current_year ?? null,
            ],
            // Include tutoring sessions and count the rows
            'tutoring_sessions' => $this->student->studentTutoringSessions ? 
                TutoringSessionResource::collection($this->student->studentTutoringSessions) : [],
            'tutoring_session_status' => $this->student->studentTutoringSessions && 
                $this->student->studentTutoringSessions->count() > 0 ? 'Assigned' : 'Unassigned',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
