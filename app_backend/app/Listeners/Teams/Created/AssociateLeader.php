<?php

namespace App\Listeners\Teams\Created;

use App\Events\Teams\Created;

class AssociateLeader
{
    public function handle(Created $event): void
    {
        $team = $event->team;
        $leader = $team->leader;

        if(! $team->employees()->where('employees.id', $leader->id)->exists()) {
            $team->employees()->attach($team->leader);
        }
    }
}
