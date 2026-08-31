<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Groups;

use Wiredspast\HabboApiWrapperPhp\DataTypes\Groups\GroupType;

/**
 * A Habbo group requested through a user
 */
class Group
{
    /**
     * @param bool $online Whether the user is online
     * @param string $id The UUID of the group
     * @param string $name The name of the group
     * @param string $description The description of the group
     * @param GroupType $type The access type of the group
     * @param string $badgeCode The badge code of the group
     * @param string $roomId The UUID of the group room
     * @param string $primaryColour The primary colour of the group
     * @param string $secondaryColour The secondary colour of the group
     * @param bool $isAdmin Whether the user is an admin of the group
     */
    public function __construct(
        public bool $online,
        public string $id,
        public string $name,
        public string $description,
        public GroupType $type,
        public string $badgeCode,
        public string $roomId,
        public string $primaryColour,
        public string $secondaryColour,
        public bool $isAdmin
    ) {}

    /**
     * Parse a received array to a Group instance
     *
     * @param array $data The received array
     *
     * @return self The parsed Group instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            online: $data['online'],
            id: $data['id'],
            name: $data['name'],
            description: $data['description'],
            type: GroupType::fromString($data['type']),
            badgeCode: $data['badgeCode'],
            roomId: $data['roomId'],
            primaryColour: $data['primaryColour'],
            secondaryColour: $data['secondaryColour'],
            isAdmin: $data['isAdmin']
        );
    }
}