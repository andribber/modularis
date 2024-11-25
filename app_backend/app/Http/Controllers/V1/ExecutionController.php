<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modules\ExecutionRequest;
use App\Managers\ModuleManager;
use App\Models\Module;
use App\Models\Tenant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class ExecutionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly ModuleManager $moduleManager)
    {
    }

    public function __invoke(ExecutionRequest $request, Tenant $tenant, Module $module): JsonResponse
    {
        return response()->json([
            'result' => $this->moduleManager->handle($tenant, $module, $request->validated()),
        ]);
    }
}
