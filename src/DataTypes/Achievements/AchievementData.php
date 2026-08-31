<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements;

/**
 * The metadata of an achievement
 */
class AchievementData
{
    /**
     * @param int $id The ID of the achievement
     * @param string $name The name of the achievement
     * @param string $creationTime The creation time of the achievement
     * @param AchievementState $state The state of the achievement
     * @param string $category The category of the achievement
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $creationTime,
        public AchievementState $state,
        public string $category
    ) {}

    /**
     * Parse a received array to an AchievementData instance
     *
     * @param array $data The received array
     *
     * @return self The parsed AchievementData instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            creationTime: $data['creationTime'],
            state: AchievementState::fromString($data['state']),
            category: $data['category']
        );
    }
}