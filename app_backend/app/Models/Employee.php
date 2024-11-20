<?php

namespace App\Models;

use App\Events\Employees\Created;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'occupation',
        'salary',
        'area', //teams feature
        'registry',
        'bank_account',
    ];

    protected $casts = [
        'bank_account' => 'array',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $dispatchesEvents = [
        'created' => Created::class,
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
