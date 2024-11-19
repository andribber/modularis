<?php

namespace App\Http\Queries;

use App\Models\Tenant;

class TenantQuery extends WithAppendsQueryBuilder
{
    public function __construct()
    {
        parent::__construct(Tenant::query());

        $this->allowedIncludes(['modules']);

        $this->allowedAppends([
            'me',
            'owner',
        ]);

        $this->defaultSorts('-id');
    }
}
