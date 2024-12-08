<?php

namespace App\Listeners\Teams\Created;

use App\Events\Teams\Created;

class AssociateLeader
{
    public function handle(Created $event): void
    {
        $team = $event->team;

        $team->employees()->attach($team->leader);
    }
}
