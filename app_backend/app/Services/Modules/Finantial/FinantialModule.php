<?php

namespace App\Services\Modules\Finantial;

use App\Enums\ServiceEnum;
use App\Models\Module as Module;
use App\Services\Modules\Contracts\ModuleContract;
use App\Services\Modules\Finantial\Services\Finantial\Finantial;
use App\Services\Modules\Interfaces\Service;
use Illuminate\Database\Eloquent\Model;

class FinantialModule extends ModuleContract
{
    public function __construct(
        private readonly Finantial $finantial,
    ) {
    }

    public function getModel(): Model
    {
        return Module::where('class', self::class)->first();
    }

    public function getService(?string $service): ?Service
    {
        return match ($service) {
            ServiceEnum::FINANTIAL->value => $this->finantial,
            default => null
        };
    }

    protected function execute(array $parameters): mixed
    {
        return $this->action->run($this->tenant, $parameters);
    }
}
