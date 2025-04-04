<?php

namespace App\Http\Resources\Api\TutoringSessions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TutoringSessionResource extends JsonResource
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
            'tutor' => [
                'id' => $this->tutor->user->id,
                'name' => $this->tutor->user->first_name . ' ' . $this->tutor->user->last_name,
                'email' => $this->tutor->user->email,
            ],
            'student' => [
                'id' => $this->student->user->id,
                'name' => $this->student->user->first_name . ' ' . $this->student->user->last_name,
                'email' => $this->student->user->email,
                'major' => [
                    'id' => $this->student->major_id,
                    'name' => $this->student->major->name ?? null
                ]
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
