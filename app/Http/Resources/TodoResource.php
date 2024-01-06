<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $label
 * @property User $user
 */
class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->resource->tasks);
        return [
            'id'    => $this->id,
            'label' => $this->label,
            'user'  => UserResource::make($this->user),
            'tasks' => [
                'data'      => $this->resource->tasks,
                'length'    => $this->tasks->count() 
            ],
        ];
    }
}
