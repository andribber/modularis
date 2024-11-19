<?php

namespace App\Services\Modules\Employees;

use App\Models\Module;
use App\Services\Modules\Contracts\ModuleContract;
use App\Services\Modules\Employees\Actions\Employee\Employee;
use App\Services\Modules\Interfaces\Service;
use Illuminate\Database\Eloquent\Model;

class EmployeesModule extends ModuleContract
{
    public function __construct(
        private Employee $employee,
    ) {
    }

    public function getModel(): Model
    {
        return Module::where('class', self::class)->first();
    }

    public function getService(string $service): Service
    {
        return match ($service) {
            Employee::class => $this->employee,
        };
    }

    protected function execute(): void
    {
    }
}
