<?php

namespace App\Services\Modules\Employees\Services\Team\Actions;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use App\Models\Tenant;
use App\Services\Modules\Employees\Services\Team\Rules\EmployeeBelongsToTenant;
use App\Services\Modules\Interfaces\Action;
use Illuminate\Validation\Rule;

class Edit implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $team = $tenant->teams()->where('id', $parameters['team_id'])->first();

        if (isset($parameters['leader_id'])) {
            $oldLeader = $team->leader_id;
            $team->employees()->attach($parameters['leader_id']);
            $team->employees()->detach($oldLeader);
        }

        unset($parameters['team_id']);

        $team->update($parameters);

        return $team->refresh();
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'service' => ['string', 'required', Rule::in([ServiceEnum::TEAM->value])],
            'action' => ['string', 'required', Rule::in([ActionEnum::EDIT->value])],
            'instructions' => ['array', 'required'],
            'instructions.team_id' => ['required', 'string', 'exists:teams,id'],
            'instructions.leader_id' => ['sometimes', 'string', new EmployeeBelongsToTenant($tenant)],
            'instructions.name' => ['sometimes', 'string', 'max:255'],
            'instructions.description' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
