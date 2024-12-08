<?php

namespace App\Providers;

use App\Events\Employees\Created as EmployeeCreated;
use App\Events\Teams\Created as TeamCreated;
use App\Events\User\Created as UserCreated;
use App\Listeners\Employees\Created\CreateUser;
use App\Listeners\Teams\Created\AssociateLeader;
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

        TeamCreated::class => [
            AssociateLeader::class,
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
