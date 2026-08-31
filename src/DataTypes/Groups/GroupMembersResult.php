<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Groups;

/**
 * A list of group members
 */
class GroupMembersResult
{
    /**
     * @param GroupMember[] $members The list of group members
     */
    public function __construct(
        public array $members
    ) {}

    /**
     * Parse a received array to a GroupMembersResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed GroupMembersResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            members: array_map(
                function($memberData) {
                    return GroupMember::fromArray($memberData);
                },
                $data
            )
        );
    }
}