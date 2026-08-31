<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements;

/**
 * A list of user achievements
 */
class UserAchievementsResult
{
    /**
     * @param UserAchievement[] $achievements A list of user achievements
     */
    public function __construct(
        public array $achievements
    ) {}

    /**
     * Parse a received array to an UserAchievementsResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserAchievementsResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            achievements: array_map(
                function (array $achievement) {
                    return UserAchievement::fromArray($achievement);
                },
                $data
            )
        );
    }
}