<?php

namespace App\Services\Modules\Infrastructure;

use App\Services\Modules\Contracts\ModuleContract;
use App\Services\Modules\Finantial\FinantialModule;

class ModuleProxy
{
    public function __construct(
        private FinantialModule $finantial,
    ) {
    }

    public function getModule(string $moduleClass): ModuleContract
    {
        return match ($moduleClass) {
            FinantialModule::class => $this->finantial,
        };
    }
}
