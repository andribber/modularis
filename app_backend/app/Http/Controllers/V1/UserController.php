<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Queries\UserQuery;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function show(UserQuery $query): JsonResource
    {
        return new UserResource(
            $query
                ->where('id', auth()->user()?->id)
                ->firstOrFail(),
        );
    }
}
