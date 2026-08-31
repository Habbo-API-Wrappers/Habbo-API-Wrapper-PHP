<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Badges;

/**
 * The list of badges obtained by a user
 */
class UserBadgesResult
{
    /**
     * @param Badge[] $badges The list of badges obtained by the user
     */
    public function __construct(
        public array $badges
    ) {}

    /**
     * Parse a received array to a UserBadgesResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserBadgesResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            badges: array_map(
                function ($badge) {
                    return Badge::fromArray($badge);
                },
                $data
            )
        );
    }
}