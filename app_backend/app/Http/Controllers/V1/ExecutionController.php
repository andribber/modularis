<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modules\ExecutionRequest;
use App\Managers\ModuleManager;
use App\Models\ModuleTenant;
use App\Models\Tenant;
use App\Services\Modules\Infrastructure\ModuleProxy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExecutionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private ModuleManager $moduleManager,
        private ModuleProxy $moduleProxy,
    ) {
    }

    public function __invoke(Tenant $tenant, ExecutionRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        $module = $this->moduleProxy->getModule($data['module']);

        $this->authorize('access', ModuleTenant::class, [$tenant, $module]);

        $this->moduleManager->handle($tenant, $data);
    }
}
