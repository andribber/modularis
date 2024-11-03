<?php

namespace App\Models;

use App\Traits\InteractsWithObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory;
    use InteractsWithObject;
    use SoftDeletes;

    protected $keyType = 'string';

    protected $casts = [
        'data' => 'object',
        'modules' => 'object',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'email_verified_at' => 'timestamp',
    ];

    protected $fillable = [
        'data',
        'name',
        'email',
        'cnpj',
        'email_verified_at',
        'modules',
    ];

    protected $hidden = [
        'data',
    ];


    public function modules(): HasManyThrough
    {
        return $this->hasManyThrough(Module::class, TenantModule::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(TenantUser::class)
            ->withTimestamps()
            ->withPivot('role');
    }

    public function verifyPermissions(string $moduleClass): bool
    {
        return $this->modules()
            ->where('class', $moduleClass)
            ->accessible()
            ->exists();
    }
}
