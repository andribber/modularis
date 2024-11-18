<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'class' => $this->class,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'users' => $this->whenLoaded('users', UserModuleResource::collection($this->userModule)),
        ];
    }
}
