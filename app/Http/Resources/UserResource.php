<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->user->created_at,
            'document' => $this->user->document,
            'id' => $this->user->id,
            'name' => $this->user->name,
            'updated_at' => $this->user->updated_at,
        ];
    }
}
