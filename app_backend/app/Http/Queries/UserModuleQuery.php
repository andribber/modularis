<?php

namespace App\Http\Queries;

use App\Models\UserModule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserModuleQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(UserModule::query());

        $this->allowedFilters([
            AllowedFilter::exact('user_id', 'user.id'),
        ]);

        $this->allowedIncludes([
            'user',
            'module',
        ]);
    }
}
