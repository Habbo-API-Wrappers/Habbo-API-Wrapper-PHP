<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Groups;

/**
 * A member of a group
 */
class GroupMember
{
    /**
     * @param bool $online Whether the user is online
     * @param string $gender The gender of the user
     * @param string $motto The motto of the user
     * @param string $habboFigure The figure string of the user
     * @param string $memberSince When the user created their account
     * @param string $uniqueId The UUID of the user
     * @param string $name The name of the user
     * @param bool $isAdmin Whether the user is an admin of the group
     */
    public function __construct(
        public bool $online,
        public string $gender,
        public string $motto,
        public string $habboFigure,
        public string $memberSince,
        public string $uniqueId,
        public string $name,
        public bool $isAdmin
    ) {}

    /**
     * Parse a received array to a GroupMember instance
     *
     * @param array $data The received array
     *
     * @return self The parsed GroupMember instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            online: $data['online'],
            gender: $data['gender'],
            motto: $data['motto'],
            habboFigure: $data['habboFigure'],
            memberSince: $data['memberSince'],
            uniqueId: $data['uniqueId'],
            name: $data['name'],
            isAdmin: $data['isAdmin']
        );
    }
}