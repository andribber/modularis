<?php

namespace App\Models\ModuleServices\Finances;

use App\Enums\Module\Finances\Type;
use App\Events\Finances\Created;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finantial extends Model
{
    use SoftDeletes;

    protected $table = 'finances';
    protected $keyType = 'string';

    protected $fillable = [
        'amount',
        'description',
        'operator_id',
        'tenant_id',
        'type',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'type' => Type::class,
        'updated_at' => 'timestamp',
    ];

    protected $dispatchesEvents = [
        'created' => Created::class,
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
