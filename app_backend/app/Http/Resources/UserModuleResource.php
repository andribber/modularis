<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserModuleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user_id' => $this->user->id,
            'module_id' => $this->module->id,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
