<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements;

/**
 * A list of achievements
 */
class AchievementsResult
{
    /**
     * @param Achievement[] $achievements The achievements
     */
    public function __construct(
        public array $achievements
    ) {}

    /**
     * Parse a received array to an AchievementsResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed AchievementsResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            achievements: array_map(
                function (array $achievement) {
                    return Achievement::fromArray($achievement);
                },
                $data
            )
        );
    }
}