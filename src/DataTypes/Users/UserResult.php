<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users;

/**
 * A users profile
 */
class UserResult
{
    /**
     * @param string $uniqueId The UUID of the user
     * @param string $name The name of the user
     * @param string $figureString The figure string of the user
     * @param string $motto The motto of the user
     * @param bool|null $online Whether the user is online or not (null if the profile is private)
     * @param string|null $lastAccessTime When the user last logged in (null if the profile is private)
     * @param string|null $memberSince When the user created their account (null if the profile is private)
     * @param bool $profileVisible Whether the profile is visible (the profile is private if it is false)
     * @param int|null $currentLevel The current level of the user (null if the profile is private)
     * @param int|null $currentLevelCompletePercent The users progress to the next level (null if the profile is private)
     * @param int|null $totalExperience The total experience points of the user (null if the profile is private)
     * @param int|null $starGemCount The amount of star gems the user has received (null if the profile is private)
     * @param SelectedBadge[] $selectedBadges The badges the user is wearing (empty if the profile is private)
     */
    public function __construct(
        public string $uniqueId,
        public string $name,
        public string $figureString,
        public string $motto,
        public ?bool $online,
        public ?string $lastAccessTime,
        public ?string $memberSince,
        public bool $profileVisible,
        public ?int $currentLevel,
        public ?int $currentLevelCompletePercent,
        public ?int $totalExperience,
        public ?int $starGemCount,
        public array $selectedBadges
    ) {}

    /**
     * Parse a received array to a UserResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            uniqueId: $data['uniqueId'],
            name: $data['name'],
            figureString: $data['figureString'],
            motto: $data['motto'],
            online: $data['online'] ?? null,
            lastAccessTime: $data['lastAccessTime'] ?? null,
            memberSince: $data['memberSince'] ?? null,
            profileVisible: $data['profileVisible'],
            currentLevel: $data['currentLevel'] ?? null,
            currentLevelCompletePercent: $data['currentLevelCompletePercent'] ?? null,
            totalExperience: $data['totalExperience'] ?? null,
            starGemCount: $data['starGemCount'] ?? null,
            selectedBadges: array_map(
                function ($badge) {
                    return SelectedBadge::fromArray($badge);
                },
                $data['selectedBadges']
            )
        );
    }
}