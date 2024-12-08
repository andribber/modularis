<?php

namespace App\Listeners\User\Created;

use App\Enums\Tenant\Role;
use App\Events\User\Created;
use App\Models\Tenant;

class CreateAndAttachPersonalTenant
{
    public function handle(Created $event): void
    {
        $user = $event->user;

        $tenant = Tenant::create(['name' => "Organização de {$user->name}"]);
        $user->tenants()->attach($tenant, ['role' => Role::PERSONAL]);
    }
}
