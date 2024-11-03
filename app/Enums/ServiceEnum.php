<?php

namespace App\Enums;

use App\Services\Modules\Finantial\Actions\Expense\Expense;
use ArchTech\Enums\Values;

enum ServiceEnum: string
{
    use Values;

    case EXPENSE = Expense::class;
}
