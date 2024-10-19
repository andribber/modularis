<?php

namespace App\Actions\Authentication;

use App\Contracts\Authenticable;
use App\Enums\Role as EnumsRole;
use App\Models\PersonalAccessToken;
use App\Models\TenantUser;
use App\Models\User;
use App\Services\TokenService;
use Exception;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Namshi\JOSE\SimpleJWS;

class Login
{
    use AsAction;

    public function handle(
        Authenticable $authenticable,
        string $userAgent,
        string $tokenName = 'web_login',
    ): PersonalAccessToken {
        $tenantUser = $this->getTenantUser($authenticable);

        $service = new TokenService($tenantUser);

        $token = $service->token();
        $payload = SimpleJWS::load($token)->getPayload();

        $personalAccessToken = $tenantUser->tokens()->create([
            'id' => $payload['jti'],
            'expires_at' => $payload['exp'],
            'user_agent' => Str::limit($userAgent, 512, null),
            'name' => $tokenName,
        ]);

        $personalAccessToken->token = $token;

        return $personalAccessToken;
    }

    private function getTenantUser(Authenticable $authenticable): TenantUser
    {
        return match($autenticable::class) {
            TenantUser::class => $authenticable;
            User::class => $authenticable->tenants()->where('role', EnumsRole::PERSONAL)->withPivot('id')->first()->pivot;
            default => throw new Exception('Error while trying to login an unknown authenticable');
        }
    }
}
