<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'bio'        => $this->bio,
            'avatar_url' => $this->avatarUrl(),
            'joined_at'  => $this->created_at->format('d M Y'),
        ];
    }
}
