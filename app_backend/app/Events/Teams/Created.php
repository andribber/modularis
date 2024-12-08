<?php

namespace App\Events\Teams;

use App\Models\ModuleServices\Employees\Team;

class Created
{
    public function __construct(public readonly Team $team)
    {
    }
}
