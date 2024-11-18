<?php

namespace App\Models;

use App\Enums\ModuleRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

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

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }

    public function moduleTenant(): HasMany
    {
        return $this->hasMany(ModuleTenant::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function userModule(): HasMany
    {
        return $this->hasMany(UserModule::class);
    }

    public function canBeAccessedBy(User $user, Tenant $tenant): bool
    {
        return $this->whereHas(
            'userModule',
            fn (Builder $query) => $query->whereBelongsTo($user->id)->whereIn('role', ModuleRoles::values()),
        )
        ->whereHas(
            'moduleTenant',
            fn (Builder $query) => $query->whereBelongsTo($tenant)->where('expires_at', '>=', now()),
        );
    }

    public function scopeAccessible(Builder $query): Builder
    {
        return $query->whereHas(
            'moduleTenant',
            fn (Builder $query) => $query->where('expires_at', '>=', now()),
        );
    }
}
