<?php

namespace App\Services\Modules\Employees\Services\Employee;

use App\Enums\ActionEnum;
use App\Services\Modules\Employees\Services\Employee\Actions\Create;
use App\Services\Modules\Employees\Services\Employee\Actions\Delete;
use App\Services\Modules\Employees\Services\Employee\Actions\Edit;
use App\Services\Modules\Employees\Services\Employee\Actions\Index;
use App\Services\Modules\Employees\Services\Employee\Actions\Show;
use App\Services\Modules\Interfaces\Action;
use App\Services\Modules\Interfaces\Service;

class Employee implements Service
{
    public function __construct(
        private readonly Create $create,
        private readonly Delete $delete,
        private readonly Edit $edit,
        private readonly Index $index,
        private readonly Show $show,
    ) {
    }

    public function getAction(?string $action): ?Action
    {
        return match ($action) {
            ActionEnum::CREATE->value => $this->create,
            ActionEnum::DELETE->value => $this->delete,
            ActionEnum::EDIT->value => $this->edit,
            ActionEnum::SHOW->value => $this->show,
            ActionEnum::INDEX->value => $this->index,
            default => null
        };
    }
}
