<?php

namespace App\Http\Resources\Api\Files;

use App\Http\Resources\Api\Blogs\PostUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'file_name' => $this->file_name,
            'url_link' => $this->url_link,
            'created_at' => $this->created_at,
            'user' => new PostUserResource($this->blog?->author)
        ];
    }
}