<?php

namespace App\Services;

use App\Models\TenantUser;
use Carbon\Carbon;

class TokenService
{
    public function __construct(
        private readonly TenantUser $tenantUser,
        private readonly ?int $expiresAtInMinutes = null,
        private readonly bool $refresh = false,
    ) {
    }

    public function token(): string
    {
        $expiresAtInMinutes = is_null($this->expiresAtInMinutes)
            ? config('jwt.ttl')
            : now()->diffInMinutes(Carbon::createFromTimestamp($this->expiresAtInMinutes));

        $token = auth()
            ->setTTL($expiresAtInMinutes)
            ->claims(['tenant_id' => $this->tenantUser->tenant_id]);

        if ($this->refresh) {
            $oldTokenId = auth()->payload()->toArray()['jti'];
            $this->tenantUser->tokens()->where('personal_access_tokens.id', $oldTokenId)->delete();

            return $token->refresh();
        }

        return $token->login($this->tenantUser->user);
    }
}
