<?php

namespace App\Http\Controllers\V1;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Token\LoginRequest;
use App\Http\Resources\PersonalAccessTokenResource;
use App\Models\PersonalAccessToken;
use App\Models\TenantUser;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
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

    public function login(LoginRequest $request): JsonResource|JsonResponse
    {
        $input = $request->validated();

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];

        if (auth()->validate($credentials)) {
            $user = $this->user->where('email', $credentials['email'])->first();
            $accountOwnTenant = $this->tenantUser
                ->where('account_id', $user->id)
                ->where('role', Role::PERSONAL)
                ->first();
            $service = new TokenService($accountOwnTenant);
            $token = $service->token();
            $payload = SimpleJWS::load($token)->getPayload();

            $personalAccessToken = $this->createToken(
                $accountOwnTenant,
                $payload,
                $request->header('User-Agent') ?? '',
                'web_login',
            );

            $personalAccessToken->token = $token;

            return new PersonalAccessTokenResource($personalAccessToken);
        }

        return response()->json(status: Response::HTTP_NOT_FOUND);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    private function createToken(
        TenantUser $tenantUser,
        array $payload,
        string $userAgent,
        string $name,
    ): PersonalAccessToken {
        return $tenantUser->tokens()->create([
            'id' => $payload['jti'],
            'expires_at' => $payload['exp'],
            'user_agent' => $userAgent,
            'name' => $name,
        ]);
    }
}
