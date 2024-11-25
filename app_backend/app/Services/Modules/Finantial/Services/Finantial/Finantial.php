<?php

namespace App\Services\Modules\Finantial\Services\Finantial;

use App\Enums\ActionEnum;
use App\Services\Modules\Finantial\Services\Finantial\Actions\Create;
use App\Services\Modules\Finantial\Services\Finantial\Actions\Delete;
use App\Services\Modules\Finantial\Services\Finantial\Actions\Edit;
use App\Services\Modules\Finantial\Services\Finantial\Actions\Index;
use App\Services\Modules\Finantial\Services\Finantial\Actions\Show;
use App\Services\Modules\Interfaces\Action;
use App\Services\Modules\Interfaces\Service;

class Finantial implements Service
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
            ActionEnum::INDEX->value => $this->index,
            ActionEnum::SHOW->value => $this->show,
            default => null
        };
    }
}
