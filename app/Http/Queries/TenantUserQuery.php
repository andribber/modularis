<?php

namespace App\Http\Queries;

use App\Models\TenantUser;
use Spatie\QueryBuilder\QueryBuilder;

class TenantUserQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(TenantUser::query());

        $this->allowedIncludes([
            'user',
            'tenant',
        ]);
    }
}
