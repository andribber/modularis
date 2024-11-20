<?php

namespace App\Providers;

use App\Events\Employees\Created as EmployeeCreated;
use App\Events\User\Created as UserCreated;
use App\Listeners\Employees\Created\CreateUser;
use App\Listeners\User\Created\CreateAndAttachPersonalTenant;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        UserCreated::class => [
            CreateAndAttachPersonalTenant::class,
        ],

        EmployeeCreated::class => [
            CreateUser::class,
        ],

    ];

    public function boot(): void
    {
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
