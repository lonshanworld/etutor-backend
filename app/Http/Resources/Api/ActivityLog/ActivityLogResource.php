<?php

namespace App\Http\Resources\Api\ActivityLog;

use App\Http\Resources\Api\Users\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        return [
            'id' => $this->id,
            'visit_count' => $this->visit_count,
            'ip_address' => $this->ip_address,
            'session_login' => $this->session_login,
            'session_logout' => $this->session_logout,
            'created_at' => $this->created_at,
            'user' =>  new UserProfileResource($this->user)

        ];
    }
}
