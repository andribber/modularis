<?php

namespace App\Http\Controllers\V1;

use App\Http\Queries\TenantUserQuery;
use App\Http\Resources\UserResource;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController
{
    public function __construct(private readonly Factory $auth)
    {
    }

    public function show(TenantUserQuery $query): JsonResource
    {
        return new UserResource(
            $query
                ->where('tenant_id', auth()->payload()->get('tenant_id'))
                ->where('user_id', $this->auth->user()->id)
                ->firstOrFail(),
        );
    }
}
