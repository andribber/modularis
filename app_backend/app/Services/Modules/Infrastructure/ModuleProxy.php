<?php

namespace App\Services\Modules\Infrastructure;

use App\Services\Modules\Contracts\ModuleContract;
use App\Services\Modules\Employees\EmployeesModule;
use App\Services\Modules\Finantial\FinantialModule;

class ModuleProxy
{
    public function __construct(
        private readonly EmployeesModule $employee,
        private readonly FinantialModule $finantial,
    ) {
    }

    public function getModule(string $moduleClass): ModuleContract
    {
        return match ($moduleClass) {
            FinantialModule::class => $this->finantial,
            EmployeesModule::class => $this->employee,
        };
    }
}
