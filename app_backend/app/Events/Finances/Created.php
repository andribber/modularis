<?php

namespace App\Events\Finances;

use App\Models\ModuleServices\Finances\Finantial;

class Created
{
    public function __construct(public readonly Finantial $finantial)
    {
    }
}
