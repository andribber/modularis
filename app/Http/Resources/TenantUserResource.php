<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenantUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'document' => $this->user->document,
            'id' => $this->id,
            'name' => $this->user->name,
            'role' => $this->role,
            'updated_at' => $this->updated_at,
        ];
    }
}
