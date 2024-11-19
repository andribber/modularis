<?php

namespace App\Services\Modules\Finantial;

use App\Models\Module as Module;
use App\Services\Modules\Contracts\ModuleContract;
use App\Services\Modules\Finantial\Actions\Expense\Expense;
use App\Services\Modules\Interfaces\Service;
use Illuminate\Database\Eloquent\Model;

class FinantialModule extends ModuleContract
{
    public function __construct(
        private Expense $expense,
    ) {
    }

    public function getModel(): Model
    {
        return Module::where('class', self::class)->first();
    }

    public function getService(string $service): Service
    {
        return match ($service) {
            Expense::class => $this->expense,
        };
    }

    protected function execute(): void
    {
    }
}
