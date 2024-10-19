<?php

namespace App\Traits;

use ArchTech\Enums\Meta\Reflection;

trait InteractsWithEnumsMetaProperties
{
    public static function getInfoFromMetadata(mixed $metadata, string $metaProperty, bool $toValue = false): array
    {
        $metaProperty = $metaProperty::make($metadata);
        $return = [];

        foreach (self::cases() as $case) {
            if (Reflection::metaValue($metaProperty::class, $case) === $metaProperty->value) {
                $return[] = $toValue ? $case->value : $case;
            }
        }

        return $return;
    }

    public static function getInfoFromMetadataArray(mixed $metadata, string $metaProperty, bool $toValue = false): array
    {
        $metaProperty = $metaProperty::make($metadata);
        $return = [];

        foreach (self::cases() as $case) {
            if (in_array($metaProperty->value, Reflection::metaValue($metaProperty::class, $case))) {
                $return[] = $toValue ? $case->value : $case;
            }
        }

        return $return;
    }
}
