<?php

namespace App\Models;

use App\Contracts\Authenticable;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TenantUser extends Pivot implements Authenticable
{
    use HasFactory;

    protected $table = 'tenant_user';

    protected $keyType = 'string';

    protected $casts = [
        'created_at' => 'timestamp',
        'role' => Role::class,
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'created_at',
        'role',
        'tenant_id',
        'user_id',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(PersonalAccessToken::class, 'tenant_user_id');
    }
}
