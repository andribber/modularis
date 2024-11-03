<?php

namespace App\Services\Modules\Base\Interfaces;

interface Action
{
    public function run(array $parameters): void;
}
