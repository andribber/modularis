<?php

namespace App\Services\Modules\Finantial\Services\Finantial\Actions;

use App\Enums\Module\Finances\Status;
use App\Enums\Module\Finances\Type;
use App\Models\Tenant;
use App\Rules\UserIsAttachedToTenant;
use App\Services\Modules\Interfaces\Action;
use Illuminate\Validation\Rule;

class Create implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        return $tenant->finances()->create([
            'operator_id' => auth()->user()->id,
            ...$parameters,
        ]);
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'instructions.amount' => ['required', 'decimal:2'],
            'instructions.description' => ['required', 'string', 'max:255'],
            'instructions.status' => ['required', 'string', Rule::in(Status::values())],
            'instructions.type' => ['required', 'string', Rule::in(Type::values())],
            'instructions.user_id' => [
                'nullable',
                'string',
                'exists:users,id',
                new UserIsAttachedToTenant($tenant),
            ],
        ];
    }
}
