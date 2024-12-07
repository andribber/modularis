<?php

namespace App\Models;

use App\Enums\Module\ModuleRoles;
use App\Enums\Module\Name;
use App\Services\Modules\Contracts\ModuleContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'modules';
    protected $keyType = 'string';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => Name::class,
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

    public function moduleUser(): HasMany
    {
        return $this->hasMany(ModuleUser::class);
    }

    public function canBeAccessedBy(User $user, Tenant $tenant, Module $module): bool
    {
        return $this->whereHas(
            'moduleUser',
            fn (Builder $query) => $query
                ->whereBelongsTo($user)
                ->whereBelongsTo($module)
                ->whereIn('module_user.role', ModuleRoles::values()),
        )
            ->whereHas(
                'moduleTenant',
                fn (Builder $query) => $query
                    ->whereBelongsTo($tenant)
                    ->whereBelongsTo($module)
                    ->where('module_tenant.expires_at', '>=', now()),
            )
            ->exists();
    }

    public function getModuleAcessorService(): ModuleContract
    {
        return app($this->name->className());
    }
}
