<?php

namespace App\Events\Employees;

use App\Models\ModuleServices\Employees\Employee;

class Created
{
    public function __construct(public readonly Employee $employee)
    {
    }
}
