<?php

namespace App\Enums\Tenant;

use App\Enums\Tenant\MetaProperties\CanBeAssigned;
use App\Traits\InteractsWithEnumsMetaProperties;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Values;

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
