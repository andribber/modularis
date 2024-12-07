<?php

namespace App\Enums\Module\Finances;

use ArchTech\Enums\Values;

enum Status: string
{
    use Values;

    case CANCELED = 'canceled';
    case PAID = 'paid';
    case PROCESSING = 'processing';
    case WAITING_PAYMENT = 'waiting_payment';
}
