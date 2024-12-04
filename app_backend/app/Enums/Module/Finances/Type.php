<?php

namespace App\Enums\Module\Finances;

use ArchTech\Enums\Values;

enum Type: string
{
    use Values;

    case ADJUST = 'adjust';
    case PAYMENT = 'payment';
}