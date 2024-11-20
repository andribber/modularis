<?php

namespace App\Listeners\Employees\Created;

use App\Events\Employees\Created;
use App\Models\User;

class CreateUser
{
    public function handle(Created $event): void
    {
        $employee = $event->employee;

        $user = User::create([
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => '123',
        ]);

        $employee->updateQuietly(['user_id' => $user->id]);
    }
}
