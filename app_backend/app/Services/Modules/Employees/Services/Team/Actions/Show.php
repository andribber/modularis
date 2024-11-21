<?php

namespace App\Services\Modules\Employees\Services\Team\Actions;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;
use Illuminate\Validation\Rule;

class Show implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        return $tenant->teams()
            ->where('id', $parameters['team_id'])
            ->first();
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'service' => ['string', 'required', Rule::in([ServiceEnum::TEAM->value])],
            'action' => ['string', 'required', Rule::in([ActionEnum::SHOW->value])],
            'instructions' => ['array', 'required'],
            'instructions.team_id' => ['required', 'string', 'exists:teams,id'],
        ];
    }
}
