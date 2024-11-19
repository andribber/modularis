<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum ActionEnum: string
{
    use Values;

    case CREATE = 'create';
    case DELETE = 'delete';
    case EDIT = 'edit';
    case VIEW = 'view';
}
