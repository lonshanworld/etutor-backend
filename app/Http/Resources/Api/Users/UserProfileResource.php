<?php

namespace App\Http\Resources\Api\Users;

use App\Http\Resources\Api\Roles\RoleResource;
use App\Http\Resources\Api\Major\MajorResource;
use App\Http\Resources\Api\Subject\SubjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_birth,
            'email' => $this->email,
            'nationality' => $this->nationality,
            'gender' => $this->gender,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'passport' => $this->passport,
            'status' => $this->status,
            'role' => new RoleResource($this->role)
        ];

        switch($this->role->name) {
            case 'admin':
                $data['admin'] = [
                    'start_date' => $this->staff->start_date ?? null,
                    'end_date' => $this->staff->end_date ?? null,
                    'emergency_contact_name' => $this->staff->emergency_contact_name ?? null,
                    'emergency_contact_phone' => $this->staff->emergency_contact_phone ?? null
                ];
                break;
            case 'tutor':
                $subject = $this->tutor && $this->tutor->subject_id ? \App\Models\Subject::find($this->tutor->subject_id) : null;
                $data['tutor'] = [
                    'subject_id' => $this->tutor->subject_id ?? null,
                    'subject_name' => $subject->name ?? null,
                    'qualifications' => $this->tutor->qualifications ?? null,
                    'experience' => $this->tutor->experience ?? null
                ];
                break;
            case 'student':
                $major = $this->student && $this->student->major_id ? \App\Models\Major::find($this->student->major_id) : null;
                $data['student'] = [
                    'major_id' => $this->student->major_id ?? null,
                    'major_name' => $major->name ?? null,
                    'enrollment_date' => $this->student->enrollment_date ?? null,
                    'emergency_contact_name' => $this->student->emergency_contact_name ?? null,
                    'emergency_contact_phone' => $this->student->emergency_contact_phone ?? null
                ];
                break;
        }

        return $data;
    }
}
