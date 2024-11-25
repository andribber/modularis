<?php

namespace App\Services\Modules\Employees;

use App\Enums\ServiceEnum;
use App\Models\Module;
use App\Services\Modules\Contracts\ModuleContract;
use App\Services\Modules\Employees\Services\Employee\Employee;
use App\Services\Modules\Employees\Services\Team\Team;
use App\Services\Modules\Interfaces\Service;
use Illuminate\Database\Eloquent\Model;

class EmployeesModule extends ModuleContract
{
    public function __construct(
        private readonly Employee $employee,
        private readonly Team $team,
    ) {
    }

    public function getModel(): Model
    {
        return Module::where('class', self::class)->first();
    }

    public function getService(?string $service): ?Service
    {
        return match ($service) {
            ServiceEnum::EMPLOYEE->value => $this->employee,
            ServiceEnum::TEAM->value => $this->team,
            default => null
        };
    }

    protected function execute(array $parameters): mixed
    {
        return $this->action->run($this->tenant, $parameters);
    }
}
