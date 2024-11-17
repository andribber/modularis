<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenantUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'created_at' => $this->created_at,
            'id' => $this->id,
            'role' => $this->role,
            'tenant_id' => $this->when(! $this->resource->relationLoaded('tenant'), $this->tenant_id),
            'tenant' => new TenantResource($this->whenLoaded('tenant')),
            'updated_at' => $this->updated_at,
            'user_id' => $this->when(! $this->resource->relationLoaded('user'), $this->user_id),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
