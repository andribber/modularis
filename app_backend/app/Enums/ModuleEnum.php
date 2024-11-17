<?php

namespace App\Enums;

use App\Services\Modules\Finantial\FinantialModule;
use ArchTech\Enums\Values;

enum ModuleEnum: string
{
    use Values;

    case FINANTIAL = FinantialModule::class;
}
