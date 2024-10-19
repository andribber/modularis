<?php

namespace App\Http\Controllers\V1;

use App\Actions\Authentication\Login;
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
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    public function __construct(
        private readonly User $user,
        private readonly TenantUser $tenantUser,
        private readonly Factory $auth,
    ) {
    }

    public function index(TokenQuery $query, Tenant $tenant, Request $request): JsonResource
    {
        $this->authorize('viewAny', [PersonalAccessToken::class]);

        $tenantUser = $this->tenantUser
            ->where('user_id', $this->auth->user()->id)
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
        $this->authorize('create', [PersonalAccessToken::class]);

        $input = $request->validated();

        $user = $this->auth->user();

        $tenantUser = $this->tenantUser
            ->where('user_id', $user->id)
            ->where('tenant_id', $tenant->id)
            ->first();

        $personalAccessToken = Login::run(
            $tenantUser,
            $request->header('User-Agent') ?? '',
            $input['name'],
        );

        return new PersonalAccessTokenResource($personalAccessToken);
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

            $personalAccessToken = Login::run($user, $request->header('User-Agent') ?? '');

            return new PersonalAccessTokenResource($personalAccessToken);
        }

        return response()->json(status: Response::HTTP_NOT_FOUND);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function register(RegisterRequest $request): JsonResource
    {
        $user = $this->user->create($request->validated());

        $personalAccessToken = Login::run($user, $request->header('User-Agent') ?? '');

        return new PersonalAccessTokenResource($personalAccessToken);
    }
}
