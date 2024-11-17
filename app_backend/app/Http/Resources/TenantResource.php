<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TenantResource extends JsonResource
{
    public function toArray($request): array
    {
        $appends = [];

        if (Str::contains($request->input('appends'), 'me')) {
            $appends['me'] = new UserResource(auth()->user());
        }

        if (Str::contains($request->input('appends'), 'owner')) {
            $appends['owner'] = new UserResource($this->responsible);
        }

        return [
            'created_at' => $this->created_at,
            'id' => $this->id,
            'name' => $this->name,
            'updated_at' => $this->updated_at,
            ...$appends,
        ];
    }
}
