<?php

namespace App\Http\Queries;

use App\Models\Module;
use Spatie\QueryBuilder\QueryBuilder;

class ModuleQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Module::query());

        $this->allowedIncludes(['users']);
    }
}
