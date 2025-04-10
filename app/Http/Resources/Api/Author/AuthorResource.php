<?php

namespace App\Http\Resources\Api\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'name' => implode(' ', array_filter([$this->first_name, $this->middle_name, $this->last_name])),
            'profile_picture' => $this->profile_picture
        ];
    }
}
