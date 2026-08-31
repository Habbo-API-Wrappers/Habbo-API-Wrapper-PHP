<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements;

/**
 * An achievement and its level requirements
 */
class Achievement
{
    /**
     * @param AchievementData $achievement The metadata of the achievement
     * @param LevelRequirement[] $levelRequirements The level requirements of the achievement
     */
    public function __construct(
        public AchievementData $achievement,
        public array $levelRequirements
    ) {}

    /**
     * Parse a received array to an Achievement instance
     *
     * @param array $data The received array
     *
     * @return self The parsed Achievement instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            achievement: AchievementData::fromArray($data['achievement']),
            levelRequirements: array_map(
                function(array $levelRequirement) {
                    return LevelRequirement::fromArray($levelRequirement);
                },
                $data['levelRequirements']
            )
        );
    }
}