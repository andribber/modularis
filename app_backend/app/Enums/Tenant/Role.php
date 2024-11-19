<?php

namespace App\Enums\Tenant;

use App\Enums\Tenant\MetaProperties\CanAccess;
use App\Enums\Tenant\MetaProperties\CanAdmin;
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

    #[CanAccess(true)]
    #[CanAdmin(true)]
    #[CanBeAssigned(true)]
    case ADMIN = 'admin';

    #[CanAccess(true)]
    #[CanAdmin(true)]
    #[CanBeAssigned(false)]
    case OWNER = 'owner';

    #[CanAccess(true)]
    #[CanAdmin(true)]
    #[CanBeAssigned(false)]
    case PERSONAL = 'personal';

    #[CanAccess(true)]
    #[CanAdmin(false)]
    #[CanBeAssigned(true)]
    case OPERATOR = 'operator';

    #[CanAccess(true)]
    #[CanAdmin(false)]
    #[CanBeAssigned(true)]
    case VIEWER = 'viewer';

    public static function assignableRoles(bool $toValue = false): array
    {
        return self::getInfoFromMetadata(true, CanBeAssigned::class, $toValue);
    }

    public static function canAccess(bool $toValue = false): array
    {
        return self::getInfoFromMetadata(true, CanAccess::class, $toValue);
    }

    public static function canAdmin(bool $toValue = false): array
    {
        return self::getInfoFromMetadata(true, CanAdmin::class, $toValue);
    }
}
