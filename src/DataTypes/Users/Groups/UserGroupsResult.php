<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Groups;

/**
 * A list of groups that a user is in
 */
class UserGroupsResult
{
    /**
     * @param Group[] $groups The list of groups that the user is in
     */
    public function __construct(
        public array $groups
    ) {}

    /**
     * Parse a received array to a UserGroupsResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserGroupsResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            groups: array_map(
                function ($group) {
                    return Group::fromArray($group);
                },
                $data
            )
        );
    }
}