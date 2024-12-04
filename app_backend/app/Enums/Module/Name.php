<?php

namespace App\Enums\Module;

use App\Enums\Module\MetaProperties\AvailableServices;
use App\Enums\Module\MetaProperties\ClassName;
use App\Enums\ServiceEnum;
use App\Services\Modules\Employees\EmployeesModule;
use App\Services\Modules\Finantial\FinantialModule;
use App\Traits\InteractsWithEnumsMetaProperties;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Values;

#[Meta(ClassName::class, AvailableServices::class)]
enum Name: string
{
    use InteractsWithEnumsMetaProperties;
    use Metadata;
    use Values;

    #[
        ClassName(FinantialModule::class),
        AvailableServices([ServiceEnum::FINANTIAL]),
    ]
    case FINANTIAL = 'finantial';

    #[
        ClassName(EmployeesModule::class),
        AvailableServices([
            ServiceEnum::EMPLOYEE,
            ServiceEnum::TEAM,
        ]),
    ]
    case EMPLOYEES = 'employees';

    public static function resolveClass(string $name)
    {
        return match ($name) {
            self::EMPLOYEES->value => self::EMPLOYEES->className(),
            self::FINANTIAL->value => self::FINANTIAL->className(),
        };
    }
}
