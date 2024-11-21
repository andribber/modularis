<?php

namespace App\Models\ModuleServices\Employees;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{ 
    use HasFactory;

    protected $table = 'teams';
    protected $keyType = 'string';

    protected $fillable = [
        'tenant_id',
        'leader_id',
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'leader_id');
    }
}
