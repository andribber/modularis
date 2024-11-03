<?php

namespace App\Services\Modules\Base\Interfaces;

interface Service
{
    public function getAction(string $action): Action;
}
