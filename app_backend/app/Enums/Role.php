<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Role: string
{
    use Values;

    case ADMIN = 'admin';

    case OWNER = 'owner';

    case PERSONAL = 'personal';

    case OPERATOR = 'operator';

    case VIEWER = 'viewer';
}
