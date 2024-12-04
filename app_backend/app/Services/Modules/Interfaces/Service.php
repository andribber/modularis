<?php

namespace App\Services\Modules\Interfaces;

interface Service
{
    public function getAction(?string $action): ?Action;
}
