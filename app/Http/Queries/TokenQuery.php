<?php

namespace App\Http\Queries;

use App\Models\PersonalAccessToken;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TokenQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(PersonalAccessToken::query());

        $this->allowedFilters([
            'name',
            AllowedFilter::exact('id'),
        ]);

        $this->defaultSorts('-id');
    }
}
