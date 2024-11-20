<?php

namespace App\Services\Modules\Interfaces;

use App\Models\Tenant;

interface Service
{
    public function getAction(string $action): Action;
}
