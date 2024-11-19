<?php

namespace App\Enums\Module;

use ArchTech\Enums\Values;

enum ModuleRoles: string
{
    use Values;

    case VIEWER = 'viewer';
    case EDITOR = 'editor';
}
