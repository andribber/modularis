<?php

namespace App\Services\Modules\Employees\Actions\Employee;

use App\Enums\ActionEnum;
use App\Services\Modules\Employees\Actions\Employee\Controls\Create;
use App\Services\Modules\Employees\Actions\Employee\Controls\Delete;
use App\Services\Modules\Employees\Actions\Employee\Controls\Edit;
use App\Services\Modules\Employees\Actions\Employee\Controls\Index;
use App\Services\Modules\Employees\Actions\Employee\Controls\Show;
use App\Services\Modules\Interfaces\Action;
use App\Services\Modules\Interfaces\Service;

class Employee implements Service
{
    public function __construct(
        private Create $create,
        private Delete $delete,
        private Edit $edit,
        private Index $view,
        private Show $show,
    ) {
    }

    public function getAction(string $action): Action
    {
        return match ($action) {
            ActionEnum::CREATE->value => $this->create,
            ActionEnum::DELETE->value => $this->delete,
            ActionEnum::EDIT->value => $this->edit,
            ActionEnum::SHOW->value => $this->show,
            ActionEnum::INDEX->value => $this->view,
        };
    }
}
