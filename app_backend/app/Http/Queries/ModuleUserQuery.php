<?php

namespace App\Http\Queries;

use App\Models\ModuleUser;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ModuleUserQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(ModuleUser::query());

        $this->allowedFilters([
            AllowedFilter::exact('user_id', 'user.id'),
        ]);

        $this->allowedIncludes([
            'user',
            'module',
        ]);
    }
}
