<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum ServiceEnum: string
{
    use Values;

    case EMPLOYEE = 'employee';
    case FINANTIAL = 'finantial';
    case TEAM = 'team';
}
