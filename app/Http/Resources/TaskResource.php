<?php

namespace App\Http\Resources;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Todo $todo
 * @property string $label
 * @property boolean $is_completed
 */
class TaskResource extends JsonResource
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
            'todo'          => TodoResource::make($this->whenLoaded('todo')),
            // 'todo'          => TodoResource::make($this->whenLoaded('todo')),
            'status'        => $this->whenNotNull(new StatusResource($this->status)),
            'label'         => $this->label,
            'is_completed'  => $this->is_completed,
        ];
    }
}
