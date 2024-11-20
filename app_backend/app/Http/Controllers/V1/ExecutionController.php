<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modules\ExecutionRequest;
use App\Managers\ModuleManager;
use App\Models\Module;
use App\Models\ModuleTenant;
use App\Models\Tenant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExecutionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private ModuleManager $moduleManager)
    {
    }

    public function __invoke(ExecutionRequest $request, Tenant $tenant, Module $module)
    {
        $this->authorize('access', [ModuleTenant::class, $tenant, $module]);

        $this->moduleManager->handle($tenant, $module, $request->validated());
    }
}
