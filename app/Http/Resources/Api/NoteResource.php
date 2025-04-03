<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\Files\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
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
            'content' => $this->content,
            'files' => FileResource::collection($this->whenLoaded('files'))
        ];
    }
}
