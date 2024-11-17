<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modules\ModuleRequest;
use App\Managers\ModuleManager;
use Laravel\Horizon\Exceptions\ForbiddenException;

class ModuleController extends Controller
{
    public function __construct(private ModuleManager $moduleManager)
    {
    }

    public function __invoke(ModuleRequest $request)
    {
        $tenant = auth()->tenant();
        $data = $request->validated();

        if(! $tenant->verifyPermissions($data['module'])) {
            throw new ForbiddenException('403');
        }

        $this->moduleManager->handle($tenant, $data);
    }
}
