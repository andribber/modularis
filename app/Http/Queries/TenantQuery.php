<?php

namespace App\Http\Queries;

use App\Models\Tenant;
use Spatie\QueryBuilder\QueryBuilder;

class TenantQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Tenant::query());

        $this->defaultSorts('-id');
    }
}
