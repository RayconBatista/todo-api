<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'priority'  => $this->priority,
            'description'  => $this->description,
            'active'  => $this->active,
            'users'  => UserResource::collection($this->users),
            'todos' => TodoResource::collection($this->todos),
            'tags' => $this->tags
        ];
    }
}
