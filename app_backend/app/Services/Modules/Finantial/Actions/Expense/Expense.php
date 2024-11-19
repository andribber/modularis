<?php

namespace App\Services\Modules\Finantial\Actions\Expense;

use App\Enums\ActionEnum;
use App\Services\Modules\Finantial\Actions\Expense\Controls\Create;
use App\Services\Modules\Interfaces\Action;
use App\Services\Modules\Interfaces\Service;

class Expense implements Service
{
    public function __construct(
        private Create $create,
    ) {
    }

    public function getAction(string $action): Action
    {
        return match ($action) {
            ActionEnum::CREATE->value => $this->create,
        };
    }
}
