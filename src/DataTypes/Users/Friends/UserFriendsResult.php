<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Friends;

/**
 * A list of friends of a user
 */
class UserFriendsResult
{
    /**
     * @param Friend[] $friends The list of friends of the user
     */
    public function __construct(
        public array $friends
    ) {}

    /**
     * Parse a received array to a UserFriendsResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserFriendsResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            friends: array_map(
                function ($friend) {
                    return Friend::fromArray($friend);
                },
                $data
            )
        );
    }
}