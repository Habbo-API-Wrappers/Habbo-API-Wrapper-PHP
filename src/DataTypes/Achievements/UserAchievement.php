<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements;

/**
 * An achievement held by a user
 */
class UserAchievement
{
    /**
     * @param AchievementData $achievement The achievements metadata
     * @param int $level The users current level for the achievement
     * @param int $score The users current score for the achievement
     */
    public function __construct(
        public AchievementData $achievement,
        public int $level,
        public int $score
    ) {}

    /**
     * Parse a received array to an UserAchievement instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserAchievement instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            achievement: AchievementData::fromArray($data['achievement']),
            level: $data['level'],
            score: $data['score']
        );
    }
}