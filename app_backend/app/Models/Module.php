<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Module extends Model
{
    protected $table = 'modules';
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'class',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function tenants(): HasManyThrough
    {
        return $this->hasManyThrough(Tenant::class, TenantModule::class);
    }

    public function tenantModule(): HasMany
    {
        return $this->hasMany(TenantModule::class);
    }

    public function scopeAccessible(Builder $query): Builder
    {
        return $query->whereHas(
            'tenantModule',
            fn (Builder $query) => $query->where('expires_at', '>=', now()),
        );
    }
}
