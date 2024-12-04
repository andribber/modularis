<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ModuleTenant extends Pivot
{
    protected $table = 'module_tenant';
    protected $keyType = 'string';

    protected $casts = [
        'created_at' => 'timestamp',
        'expires_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'expires_at',
        'created_at',
        'updated_at',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
