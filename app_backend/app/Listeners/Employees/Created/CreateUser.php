<?php

namespace App\Listeners\Employees\Created;

use App\Enums\Tenant\Role;
use App\Events\Employees\Created;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('password'),
            ],
        );

        $employee->updateQuietly(['user_id' => $user->id]);
        $employee->tenant->users()->attach($user->id, ['role' => Role::VIEWER]);
    }
}
