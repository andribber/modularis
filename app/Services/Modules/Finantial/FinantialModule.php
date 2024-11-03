<?php

namespace App\Services\Modules\Finantial;

use App\Services\Modules\Base\Interfaces\Service;
use App\Services\Modules\Contracts\ModuleContract as Module;
use App\Services\Modules\Finantial\Actions\Expense\Expense;

class FinantialModule extends Module
{
    public function __construct(
        private Expense $expense,
    ) {
    }

    public function getService(string $service): Service
    {
        return match($service) {
            Expense::class => $this->expense,
        };
    }

    protected function execute(): void
    {
    }
}
