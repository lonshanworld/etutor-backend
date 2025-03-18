<?php

namespace App\Http\Resources\Api\Staff;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Roles\RoleResource;

class StaffResource extends JsonResource
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
            
            // Include staff-specific data
            'staff' => [
                'id' => $this->staff->id ?? null,
                'emergency_contact_name' => $this->staff->emergency_contact_name ?? null,
                'emergency_contact_phone' => $this->staff->emergency_contact_phone ?? null,
                'start_date' => $this->staff->start_date ?? null,
                'end_date' => $this->staff->end_date ?? null,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
