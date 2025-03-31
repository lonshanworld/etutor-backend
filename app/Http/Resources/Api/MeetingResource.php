<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'meeting_date' => $this->meeting_date,
            'meeting_time' => $this->meeting_time,
            'meeting_type' => $this->meeting_type,
            'location' => $this->location,
            'platform' => $this->platform,
            'meeting_link' => $this->meeting_link,
            'participants' => $this->participants->map(function($participant) {
                return [
                    'id' => $participant->user->id,
                    'name' => $participant->user->first_name . ' ' . $participant->user->last_name,
                    'email' => $participant->user->email,
                ];
            }),
            'status' => now()->setTimeFromTimeString($this->meeting_time)
                           ->gt(now()) ? 'upcoming' : 'past',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}