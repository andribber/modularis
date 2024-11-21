<?php

namespace App\Services\Modules\Employees\Services\Team\Actions;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;
use Illuminate\Validation\Rule;

class GetUsers implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $team = $tenant->teams()
            ->where('id', $parameters['team_id'])
            ->first();

        return $team->load('employees');
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'service' => ['string', 'required', Rule::in([ServiceEnum::TEAM->value])],
            'action' => ['string', 'required', Rule::in([ActionEnum::GET_USERS->value])],
            'instructions' => ['array', 'required'],
            'instructions.team_id' => ['required', 'string', 'exists:teams,id'],
        ];
    }
}
