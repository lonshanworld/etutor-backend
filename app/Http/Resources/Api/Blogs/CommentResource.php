<?php

namespace App\Http\Resources\Api\Blogs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'user' => new PostUserResource($this->user),
            'blog_id' => $this->blog_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
