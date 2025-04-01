<?php

namespace App\Http\Resources\Api\Record;

use App\Http\Resources\Api\Meeting\MeetingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
            'meeting_id' => $this->meeting_id,
            'record_url' => $this->record_url,
            'created_at' => $this->created_at,
            'meeting' => new MeetingResource($this->whenLoaded('meeting')),
        ];  
    }
}
