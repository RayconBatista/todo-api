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
            'id'            => $this->id,
            'name'          => $this->name,
            'priority'      => $this->priority,
            'description'   => $this->description,
            'active'        => $this->active,
            'users'         => $this->when($this->users->count() >= 1, UserResource::collection($this->users)),
            'todos'         => $this->when($this->todos->count() >= 1, TodoResource::collection($this->todos)),
            'tags'          => $this->when($this->tags->count() >= 1, TagResource::collection($this->tags)),
        ];
    }
}
