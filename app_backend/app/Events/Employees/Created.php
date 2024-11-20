<?php

namespace App\Events\Employees;

use App\Models\Employee;

class Created
{
    public function __construct(public readonly Employee $employee)
    {
    }
}
