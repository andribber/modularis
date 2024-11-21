<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum ServiceEnum: string
{
    use Values;

    case EMPLOYEE = 'employee';
    case TEAM = 'team';
    case EXPENSE = 'expense';
}
