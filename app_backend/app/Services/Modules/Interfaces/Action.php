<?php

namespace App\Services\Modules\Interfaces;

interface Action
{
    public function run(array $parameters): void;
}
