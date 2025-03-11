<?php

namespace App\Http\Resources\Api\Users;

use App\Http\Resources\Api\Roles\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
    }
}
