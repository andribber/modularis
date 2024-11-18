<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Tenant;
use App\Services\Modules\Employees\EmployeesModule;
use App\Services\Modules\Finantial\FinantialModule;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = Module::factory()->createMany([
            [
                'name' => 'employees',
                'class' => EmployeesModule::class,
            ],
            [
                'name' => 'finantial',
                'class' => FinantialModule::class,
            ],
        ]);

        Tenant::all()->each(
            fn (Tenant $tenant) => $tenant->modules()
                ->attach($modules->pluck('id'), ['expires_at' => now()->addMonth()])
        );
    }
}
