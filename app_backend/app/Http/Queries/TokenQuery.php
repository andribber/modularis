<?php

namespace App\Http\Queries;

use App\Models\PersonalAccessToken;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\Includes\IncludedRelationship;
use Spatie\QueryBuilder\QueryBuilder;

class TokenQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(PersonalAccessToken::query());

        $this->allowedIncludes([
            'tenantUser',
            new Collection([new AllowedInclude('tenant', new IncludedRelationship(), 'tenantUser.tenant')]),
        ]);

        $this->allowedFilters([
            'name',
            AllowedFilter::exact('id'),
        ]);

        $this->allowedSorts([
            'created_at',
            'id',
            'name',
        ]);

        $this->defaultSorts('-id');
    }
}
