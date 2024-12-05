<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'created_at' => $this->created_at,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'id' => $this->id,
            'modules' => $this->whenLoaded('modules', ModuleResource::collection($this->modules)),
            'name' => $this->name,
            'role' => $this->tenants()->find(auth()->payload()->get('tenant_id'))->pivot->role,
            'updated_at' => $this->updated_at,
        ];
    }
}
