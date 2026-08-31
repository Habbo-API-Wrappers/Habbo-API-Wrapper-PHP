<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements;

/**
 * The required score for a level of an achievement
 */
class LevelRequirement
{
    /**
     * @param int $level The level
     * @param int $requiredScore The required score
     */
    public function __construct(
        public int $level,
        public int $requiredScore
    ) {}

    /**
     * Parse a received array to a LevelRequirement instance
     *
     * @param array $data The received array
     *
     * @return self The parsed LevelRequirement instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            level: $data['level'],
            requiredScore: $data['requiredScore']
        );
    }
}