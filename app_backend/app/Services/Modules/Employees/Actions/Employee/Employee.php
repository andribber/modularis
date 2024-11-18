<?php

namespace App\Services\Modules\Employees\Actions\Employee;

use App\Enums\ActionEnum;
use App\Services\Modules\Base\Interfaces\Action;
use App\Services\Modules\Base\Interfaces\Service;

class Employee implements Service
{
    public function __construct(
        private Create $create,
    ) {
    }

    public function getAction(string $action): Action
    {
        return match($action) {
            ActionEnum::CREATE->value => $this->create,
        };
    }
}
