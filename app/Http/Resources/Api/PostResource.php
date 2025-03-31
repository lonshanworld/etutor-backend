<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\Author\AuthorResource;
use App\Http\Resources\Api\Files\FileResource;
use App\Http\Resources\Api\Posts\CommentResource;
use App\Http\Resources\Api\Posts\LikeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'text' => $this->text,
            'files' => FileResource::collection($this->whenLoaded('files')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'author' => new AuthorResource($this->author),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
