<?php

namespace App\Http\Controllers\V1;

use App\Enums\Tenant\Role;
use App\Http\Controllers\Controller;
use App\Http\Queries\TokenQuery;
use App\Http\Requests\Token\CreateRequest;
use App\Http\Requests\Token\LoginRequest;
use App\Http\Requests\Token\RegisterRequest;
use App\Http\Resources\PersonalAccessTokenResource;
use App\Models\PersonalAccessToken;
use App\Models\Tenant;
use App\Models\TenantUser;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Namshi\JOSE\SimpleJWS;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    public function __construct(
        private readonly User $user,
        private readonly TenantUser $tenantUser,
    ) {
    }

    public function index(TokenQuery $query, Tenant $tenant, Request $request): JsonResource
    {
        $this->authorize('viewAny', PersonalAccessToken::class);

        $tenantUser = $this->tenantUser
            ->where('user_id', auth()->user()->id)
            ->where('tenant_id', $tenant->id)
            ->first();

        $tokens = $query
            ->where('tenant_user_id', $tenantUser->id)
            ->simplePaginate($request->get('limit', config('app.pagination_limit')))
            ->appends($request->query());

        return PersonalAccessTokenResource::collection($tokens);
    }

    public function store(CreateRequest $request, Tenant $tenant): JsonResource
    {
        $this->authorize('create', PersonalAccessToken::class);

        $user = auth()->user();
        $tenantUser = $this->tenantUser
            ->where('user_id', $user->id)
            ->where('tenant_id', $tenant->id)
            ->first();

        $input = $request->validated();

        return new PersonalAccessTokenResource($this->authenticate(
            $tenantUser,
            $input['expiration_date'] ?? null,
            $input['refresh'] ?? false,
        ));
    }

    public function login(LoginRequest $request): JsonResource|JsonResponse
    {
        $input = $request->validated();

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];

        if (auth()->validate($credentials)) {
            $user = $this->user->where('email', $credentials['email'])->first();
            $userOwnTenant = $this->tenantUser
                ->where('user_id', $user->id)
                ->where('role', Role::PERSONAL)
                ->first();

            return new PersonalAccessTokenResource($this->authenticate($userOwnTenant));
        }

        return response()->json(status: Response::HTTP_NOT_FOUND);
    }

    public function register(RegisterRequest $request): JsonResource
    {
        $user = $this->user->create($request->validated());
        $userOwnTenant = $this->tenantUser
            ->where('user_id', $user->id)
            ->where('role', Role::PERSONAL)
            ->first();

        return new PersonalAccessTokenResource($this->authenticate($userOwnTenant));
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    private function authenticate(
        TenantUser $tenantUser,
        ?int $expirationDate = null,
        bool $refresh = false,
    ): PersonalAccessToken {
        $service = new TokenService($tenantUser, $expirationDate, $refresh);
        $token = $service->token();
        $payload = SimpleJWS::load($token)->getPayload();

        $personalAccessToken = $this->createToken(
            $tenantUser,
            $payload,
            'web_login',
        );

        $personalAccessToken->token = $token;

        return $personalAccessToken;
    }

    private function createToken(
        TenantUser $tenantUser,
        array $payload,
        string $name,
    ): PersonalAccessToken {
        return $tenantUser->tokens()->create([
            'id' => $payload['jti'],
            'expires_at' => $payload['exp'],
            'name' => $name,
        ]);
    }
}
