<?php

namespace App\Models;

use App\Enums\Tenant\Role;
use App\Traits\InteractsWithObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory;
    use InteractsWithObject;
    use SoftDeletes;

    protected $keyType = 'string';

    protected $casts = [
        'created_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'data' => 'object',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'data',
        'name',
    ];

    protected $hidden = [
        'data',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(TenantUser::class)
            ->withTimestamps()
            ->withPivot('role');
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class);
    }

    public function moduleTenant(): HasMany
    {
        return $this->hasMany(ModuleTenant::class);
    }

    protected function responsible(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->users()
                ->where('role', Role::PERSONAL)
                ->firstOr(
                    fn () => $this->users()
                        ->where('role', Role::OWNER)
                        ->first(),
                ),
        );
    }

    public function canAdmin(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->whereIn('role', Role::canAdmin(true))->exists();
    }

    public function canAccess(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->whereIn('role', Role::canAccess(true))->exists();
    }

    public function isAdmin(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->where('role', Role::ADMIN)->exists();
    }

    public function isOwner(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->where('role', Role::OWNER)->exists();
    }

    public function isPersonal(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->where('role', Role::PERSONAL)->exists();
    }

    protected function hasOwner(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->users()->where('role', Role::OWNER)->exists(),
        );
    }

    protected function hasPersonal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->users()->where('role', Role::PERSONAL)->exists(),
        );
    }
}
