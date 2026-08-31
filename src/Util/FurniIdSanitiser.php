<?php

namespace Wiredspast\HabboApiWrapperPhp\Util;

/**
 * Sanitises furni IDs
 */
abstract class FurniIdSanitiser
{
    /**
     * Sanitises furni IDs
     *
     * @param int $furniId The furni ID to sanitise
     *
     * @return int The sanitised furni ID
     */
    public static function sanitiseFurniId(int $furniId): int
    {
        if ($furniId < 0) $furniId *= -1;
        if ($furniId >= 2147418112) $furniId -= 2147418112;
        return $furniId;
    }
}