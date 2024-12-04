<?php

namespace Database\Seeders;

use App\Enums\Module\Name;
use App\Models\Module;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = Module::factory()->createMany([
            [
                'name' => Name::EMPLOYEES,
            ],
            [
                'name' => Name::FINANTIAL,
            ],
        ]);

        Tenant::all()->each(
            fn (Tenant $tenant) => $tenant->modules()
                ->attach($modules->pluck('id'), ['expires_at' => now()->addMonth()]),
        );
    }
}
