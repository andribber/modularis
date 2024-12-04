<?php

namespace App\Models\ModuleServices\Employees;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeTeam extends Pivot
{
    protected $table = 'employee_team';
    protected $keyType = 'string';

    protected $fillable = [
        'created_at',
        'updated_at',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
