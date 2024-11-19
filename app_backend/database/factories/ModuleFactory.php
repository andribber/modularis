<?php

namespace Database\Factories;

use App\Services\Modules\Employees\EmployeesModule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Employees',
            'class' => EmployeesModule::class,
        ];
    }
}
