<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users;

/**
 * A badge worn by a user
 */
class SelectedBadge
{
    /**
     * @param int $badgeIndex The index that the badge appears at
     * @param string $code The code of the badge
     * @param string $name The name of the badge
     * @param string $description The description of the badge
     */
    public function __construct(
        public int $badgeIndex,
        public string $code,
        public string $name,
        public string $description
    ) {}

    /**
     * Parse a received array to a SelectedBadge instance
     *
     * @param array $data The received array
     *
     * @return self The parsed SelectedBadge instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            badgeIndex: $data['badgeIndex'],
            code: $data['code'],
            name: $data['name'],
            description: $data['description']
        );
    }
}