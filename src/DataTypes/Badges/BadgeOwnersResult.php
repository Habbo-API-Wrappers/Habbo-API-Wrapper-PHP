<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Badges;

/**
 * The badge owner count
 */
class BadgeOwnersResult
{
    /**
     * @param int $ownerCount The amount of user that have the badge
     * @param string $name The name of the badge
     * @param string $description The description of the badge
     */
    public function __construct(
        public int $ownerCount,
        public string $name,
        public string $description,
    ) {}

    /**
     * Parse a received array to a BadgeOwnersResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed BadgeOwnersResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            ownerCount: $data['ownerCount'],
            name: $data['name'],
            description: $data['description']
        );
    }
}