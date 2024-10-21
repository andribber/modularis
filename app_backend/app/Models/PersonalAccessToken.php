<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalAccessToken extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $keyType = 'string';

    protected $casts = [
        'created_at' => 'timestamp',
        'expires_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'created_at',
        'expires_at',
        'id',
        'name',
        'tenant_user_id',
        'token',
        'updated_at',
        'user_agent',
    ];

    public function tenantUser(): BelongsTo
    {
        return $this->belongsTo(TenantUser::class);
    }

    protected function expiresAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Carbon::createFromTimestamp($value)->format('Y-m-d H:i:s'),
        );
    }
}
