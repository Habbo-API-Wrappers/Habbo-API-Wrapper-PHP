<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements;

/**
 * The state of an achievement
 */
enum AchievementState
{
    /**
     * The achievement is currently enabled in game
     */
    case Enabled;
    /**
     * The achievement is currently not available
     */
    case OffSeason;
    /**
     * The achievement is no longer available
     */
    case Archived;

    /**
     * Parse a received string to an AchievementState instance
     *
     * @param string $s The received string
     *
     * @return self The parsed AchievementState instance
     */
    public static function fromString(string $s): self
    {
        return match($s) {
            'ENABLED' => self::Enabled,
            'OFF_SEASON' => self::OffSeason,
            default => self::Archived,
        };
    }
}
