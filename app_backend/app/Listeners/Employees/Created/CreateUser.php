<?php

namespace App\Listeners\Employees\Created;

use App\Enums\Tenant\Role;
use App\Events\Employees\Created;
use App\Models\User;

class CreateUser
{
    public function handle(Created $event): void
    {
        $employee = $event->employee;

        $user = User::firstOrcreate(
            ['email' => $employee->email],
            [
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => '123',
            ],
        );

        $employee->updateQuietly(['user_id' => $user->id]);
        $employee->tenant->users()->attach($user->id, ['role' => Role::VIEWER]);
    }
}
