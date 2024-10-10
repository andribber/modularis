<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PingController
{
    public function show(): JsonResource
    {
        return new JsonResource(['pong']);
    }
}
