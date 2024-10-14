<?php

namespace App\Enums;

use App\Enums\MetaProperties\Role\CanBeAssigned;
use App\Traits\InteractsWithEnumsMetaProperties;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Values;

/**
 * @method bool canBeAssigned()
 */
#[Meta(CanBeAssigned::class)]
enum Role: string
{
    use InteractsWithEnumsMetaProperties;
    use Metadata;
    use Values;

    #[CanBeAssigned(true)]
    case ADMIN = 'admin';

    #[CanBeAssigned(false)]
    case OWNER = 'owner';

    #[CanBeAssigned(false)]
    case PERSONAL = 'personal';

    #[CanBeAssigned(true)]
    case OPERATOR = 'operator';

    #[CanBeAssigned(true)]
    case VIEWER = 'viewer';

    public static function assignableRoles(bool $toValue = false): array
    {
        return self::getInfoFromMetadata(true, CanBeAssigned::class, $toValue);
    }
}
