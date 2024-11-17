<?php

namespace App\Services\Modules\Contracts;

use App\Models\Tenant;
use App\Services\Modules\Base\Interfaces\Action;
use App\Services\Modules\Base\Interfaces\Service;

abstract class ModuleContract
{
    protected Tenant $tenant;
    protected Service $service;
    protected Action $action;

    public function handle()
    {
        return $this->execute();
    }

    public function setTenant(Tenant $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function setService(Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function setAction(Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    abstract public function getService(string $service): Service;

    abstract protected function execute(): void;
}
