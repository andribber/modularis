<?php

namespace App\Models;

use App\Enums\Module\ModuleRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ModuleUser extends Pivot
{
    protected $table = 'module_user';

    protected $casts = [
        'created_at' => 'timestamp',
        'role' => ModuleRoles::class,
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'role',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
