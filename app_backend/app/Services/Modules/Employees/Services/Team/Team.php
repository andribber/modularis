<?php

namespace App\Services\Modules\Employees\Services\Team;

use App\Enums\ActionEnum;
use App\Services\Modules\Employees\Services\Team\Actions\AddUsers;
use App\Services\Modules\Employees\Services\Team\Actions\Create;
use App\Services\Modules\Employees\Services\Team\Actions\Delete;
use App\Services\Modules\Employees\Services\Team\Actions\Edit;
use App\Services\Modules\Employees\Services\Team\Actions\GetUsers;
use App\Services\Modules\Employees\Services\Team\Actions\Index;
use App\Services\Modules\Employees\Services\Team\Actions\RemoveUsers;
use App\Services\Modules\Employees\Services\Team\Actions\Show;
use App\Services\Modules\Interfaces\Action;
use App\Services\Modules\Interfaces\Service;

class Team implements Service
{
    public function __construct(
        private readonly AddUsers $addUsers,
        private readonly Create $create,
        private readonly Delete $delete,
        private readonly Edit $edit,
        private readonly GetUsers $getUsers,
        private readonly Index $index,
        private readonly RemoveUsers $removeUsers,
        private readonly Show $show,
    ) {
    }

    public function getAction(?string $action): ?Action
    {
        return match ($action) {
            ActionEnum::ADD_USERS->value => $this->addUsers,
            ActionEnum::CREATE->value => $this->create,
            ActionEnum::DELETE->value => $this->delete,
            ActionEnum::EDIT->value => $this->edit,
            ActionEnum::GET_USERS->value => $this->getUsers,
            ActionEnum::INDEX->value => $this->index,
            ActionEnum::REMOVE_USERS->value => $this->removeUsers,
            ActionEnum::SHOW->value => $this->show,
            default => null,
        };
    }
}
