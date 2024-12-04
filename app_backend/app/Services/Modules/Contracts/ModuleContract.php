<?php

namespace App\Services\Modules\Contracts;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;
use App\Services\Modules\Interfaces\Service;
use Illuminate\Database\Eloquent\Model;

abstract class ModuleContract
{
    protected Tenant $tenant;
    protected Service $service;
    protected Action $action;

    public function handle(array $parameters)
    {
        return $this->execute($parameters);
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

    abstract public function getService(string $service): ?Service;
    abstract public function getModel(): ?Model;
    abstract protected function execute(array $parameters): mixed;
}
