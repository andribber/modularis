<?php

namespace App\Models;

use App\Events\User\Created;
use App\Traits\InteractsWithObject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory;
    use InteractsWithObject;

    protected $keyType = 'string';

    protected $casts = [
        'created_at' => 'timestamp',
        'data' => 'object',
        'email_verified_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'data',
        'email',
        'email_verified_at',
        'name',
        'password',
        'remember_token',
    ];

    protected $hidden = [
        'data',
        'password',
        'remember_token',
    ];

    protected $dispatchesEvents = [
        'created' => Created::class,
    ];

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class)
            ->using(TenantUser::class)
            ->withTimestamps()
            ->withPivot('role');
    }

    public function tokens(): HasManyThrough
    {
        return $this->hasManyThrough(
            PersonalAccessToken::class,
            TenantUser::class,
            'user_id',
            'tenant_user_id',
            'id',
            'id',
        );
    }

    public function getJWTIdentifier(): string
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
