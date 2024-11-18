<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalAccessTokenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'expires_at' => $this->expires_at,
            'id' => $this->id,
            'name' => $this->name,
            'tenant_user_id' => $this->when(
                ! $this->resource->relationLoaded('tenant_user'),
                $this->tenant_user_id,
            ),
            'tenant_id' => $this->tenantUser->tenant_id,
            'token' => $this->token,
            'updated_at' => $this->updated_at,
        ];
    }
}
