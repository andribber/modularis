<?php

namespace App\Models;

use App\Traits\InteractsWithObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
}
