<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModuleTenantResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'expires_at' => $this->expires_at,
            'tenant_id' => $this->when(! $this->resource->relationLoaded('tenant'), $this->tenant_id),
            'tenant' => new TenantResource($this->whenLoaded('tenant')),
            'module_id' => $this->when(! $this->resource->relationLoaded('module'), $this->module_id),
            'module' => new ModuleResource($this->whenLoaded('module')),
        ];
    }
}
