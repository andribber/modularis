<?php

namespace App\Http\Controllers\V1;

use App\Enums\Module\Name;
use App\Http\Controllers\Controller;
use App\Http\Queries\ModuleQuery;
use App\Http\Queries\ModuleUserQuery;
use App\Http\Requests\Modules\AttachUserRequest;
use App\Http\Requests\Modules\ContractRequest;
use App\Http\Resources\ModuleResource;
use App\Http\Resources\ModuleUserResource;
use App\Models\Module;
use App\Models\ModuleTenant;
use App\Models\Tenant;
use App\Services\Modules\Infrastructure\ModuleProxy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ModuleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly ModuleProxy $moduleProxy)
    {
    }

    public function index(Request $request, Tenant $tenant, ModuleQuery $query): JsonResource
    {
        $this->authorize('view', $tenant);

        return ModuleResource::collection(
            $query->whereHas('tenants', fn (Builder $query) => $query->where('tenants.id', $tenant->id))
                ->simplePaginate($request->get('limit', config('app.pagination_limit'))),
        );
    }

    public function show(Request $request, ModuleQuery $query, Tenant $tenant, Module $module): JsonResource
    {
        $this->authorize('view', $tenant);

        return ModuleResource::make(
            $query->where('modules.id', $module->id)
                ->whereHas('tenants', fn (Builder $query) => $query->where('tenants.id', $tenant->id))
                ->first(),
        );
    }

    public function contract(ContractRequest $request, Tenant $tenant): JsonResponse
    {
        // não está funcionando
        // $this->authorize('contract', $tenant);

        $class = Name::from($request->validated('name'))->className();
        $module = $this->moduleProxy->getModule($class);

        $tenant->modules()->attach($module->getModel()->id, ['expires_at' => now()->addMonth()]);

        return response()->json(status: 204);
    }

    public function attachUsers(
        AttachUserRequest $request,
        ModuleUserQuery $query,
        Tenant $tenant,
        Module $module,
    ): JsonResponse {
        $this->authorize('attachUsers', [ModuleTenant::class, $tenant, $module]);

        $userIds = [];

        foreach ($request->validated('members') as $member) {
            $userIds[] = $member['user_id'];
            $module->users()->attach($member['user_id'], ['role' => $member['role']]);
        }

        return ModuleUserResource::collection(
            $query->where('module_id', $module->id)
                ->whereIn('user_id', $userIds)
                ->simplePaginate($request->get('limit', config('app.pagination_limit')))
                ->appends($request->query()),
        )
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
