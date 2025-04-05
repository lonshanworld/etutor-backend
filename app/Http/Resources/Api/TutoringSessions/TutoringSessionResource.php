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
            'tutor' => $this->tutor->id,
            'student' => $this->student->id,
        ];
    }
}
