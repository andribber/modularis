<?php

namespace App\Http\Controllers\V1;

use App\Http\Queries\TenantUserQuery;
use App\Http\Requests\Tenant\AttachUserRequest;
use App\Http\Requests\Tenant\UpdateRoleRequest;
use App\Http\Resources\TenantUserResource;
use App\Models\Tenant;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class TenantUserController
{
    use AuthorizesRequests;

    public function index(TenantUserQuery $query, Request $request, Tenant $tenant): JsonResource
    {
        $this->authorize('viewUsers', [Tenant::class, $tenant]);

        return TenantUserResource::collection(
            $query
                ->where('tenant_id', $tenant->id)
                ->simplePaginate($request->get('limit', config('app.pagination_limit')))
                ->appends($request->query()),
        );
    }

    public function updateRole(UpdateRoleRequest $request, Tenant $tenant, User $user): JsonResource
    {
        $this->authorize('updateRole', [Tenant::class, $tenant, $user]);

        $tenantUser = TenantUser::where('user_id', $user->id)
            ->where('tenant_id', $tenant->id)
            ->firstOrFail();

        $tenantUser->update($request->validated());

        return new TenantUserResource($tenantUser);
    }

    public function attach(TenantUserQuery $query, AttachUserRequest $request, Tenant $tenant): JsonResponse
    {
        $this->authorize('attachUser', [Tenant::class, $tenant]);

        $userIds = [];

        foreach ($request->validated('members') as $member) {
            $userIds[] = $member['user_id'];
            $tenant->users()->attach($member['user_id'], ['role' => $member['role']]);
        }

        return TenantUserResource::collection(
            $query
                ->where('tenant_id', $tenant->id)
                ->whereIn('user_id', $userIds)
                ->simplePaginate($request->get('limit', config('app.pagination_limit')))
                ->appends($request->query()),
        )->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function detach(Tenant $tenant, User $user): JsonResponse
    {
        $this->authorize('detachUser', [Tenant::class, $tenant, $user]);

        $tenant->users()->detach($user);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
