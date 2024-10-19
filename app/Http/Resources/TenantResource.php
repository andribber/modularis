<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'id' => $this->id,
            'name' => $this->name,
            'updated_at' => $this->updated_at,
        ];
    }
}
