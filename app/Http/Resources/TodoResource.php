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
        // dd($this->resource->project, $this->project);
        return [
            'id'        => $this->id,
            'label'     => $this->label,
            'user'      => $this->when(auth()->user(), UserResource::make(auth()->user())),
            'project'   => $this->project,
            'tasks'     => $this->when($this->tasks->count() >= 1, [
                'data'      => TaskResource::collection($this->tasks),
                'length'    => $this->tasks->count()
            ])
        ];
    }
}
