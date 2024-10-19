<?php

namespace App\Http\Controllers\V1;

use App\Enums\Role;
use App\Http\Queries\TenantQuery;
use App\Http\Requests\Tenant\CreateRequest;
use App\Http\Requests\Tenant\UpdateRequest;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class TenantController
{
    use AuthorizesRequests;

    public function __construct(private readonly Factory $auth, private readonly Tenant $tenant)
    {
    }

    public function index(TenantQuery $query, Request $request): JsonResource
    {
        $this->authorize('viewAny', [Tenant::class]);

        return TenantResource::collection(
            $query
                ->whereHas('users', fn ($query) => $query->where('user_id', $this->auth->user()->id))
                ->simplePaginate($request->get('limit', config('app.pagination_limit')))
                ->appends($request->query()),
        );
    }

    public function show(Tenant $tenant, TenantQuery $query): JsonResource
    {
        $this->authorize('view', [Tenant::class, $tenant]);

        return new TenantResource($query->where('id', $tenant->id)->firstOrFail());
    }

    public function store(CreateRequest $request): JsonResource
    {
        $this->authorize('create', [Tenant::class]);

        $currentUser = $this->auth->user();
        $tenantData = $request->validated();

        $tenant = $this->tenant->create($tenantData);

        if (! $tenant->has_owner) {
            $currentUser->tenants()->attach($tenant, ['role' => Role::OWNER]);
        }

        return new TenantResource($tenant);
    }

    public function update(Tenant $tenant, UpdateRequest $request): JsonResource
    {
        $this->authorize('update', [Tenant::class, $tenant]);

        $tenant->update($request->validated());

        return new TenantResource($tenant);
    }

    public function delete(Tenant $tenant): JsonResponse
    {
        $this->authorize('delete', [Tenant::class, $tenant]);

        $tenant->users->each(fn (User $user) => $tenant->users()->detach($user));

        $tenant->delete();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
