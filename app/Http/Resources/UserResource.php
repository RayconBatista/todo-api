<?php

namespace App\Http\Resources;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property Todo $todos
 * @property string $verified_at
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'todos'             => TodoResource::collection($this->whenLoaded('todos'))
        ];
    }
}
