<?php

namespace App\Services\Modules\Employees\Services\Team\Actions;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use App\Models\Tenant;
use App\Services\Modules\Employees\Services\Team\Rules\EmployeeBelongsToTenant;
use App\Services\Modules\Interfaces\Action;
use Illuminate\Validation\Rule;

class Create implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $team = $tenant->teams()->create($parameters);
        $team->employees()->attach($parameters['leader_id']);

        return $team;
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'service' => ['string', 'required', Rule::in([ServiceEnum::TEAM->value])],
            'action' => ['string', 'required', Rule::in([ActionEnum::CREATE->value])],
            'instructions' => ['array', 'required'],
            'instructions.leader_id' => ['required', 'string', new EmployeeBelongsToTenant($tenant)],
            'instructions.name' => ['required', 'string', 'max:255'],
            'instructions.description' => ['required', 'string', 'max:255'],
        ];
    }
}
