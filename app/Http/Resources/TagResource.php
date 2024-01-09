<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->project);
        return [
            "id"        => $this->id,
            // "project"   => ProjectResource::make($this->project),
            'project'   => $this->project,
            "label"     => $this->label,
            "color"     => $this->color,
        ];
    }
}
