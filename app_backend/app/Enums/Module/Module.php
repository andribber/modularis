<?php

namespace App\Enums\Module;

use App\Enums\Tenant\MetaProperties\ClassName;
use App\Services\Modules\Employees\EmployeesModule;
use App\Services\Modules\Finantial\FinantialModule;
use App\Traits\InteractsWithEnumsMetaProperties;
use ArchTech\Enums\Values;

enum Name: string
{
    use Values;
    use InteractsWithEnumsMetaProperties;

    #[ClassName(FinantialModule::class)]
    case FINANTIAL = 'finantial';

    #[ClassName(EmployeesModule::class)]
    case EMPLOYEES = 'employees';

    public static function resolveClass(string $name)
    {
        return match($name) {
            self::EMPLOYEES->value => self::EMPLOYEES->className(),
            self::FINANTIAL->value => self::EMPLOYEES->className(),
        };
    }
}
