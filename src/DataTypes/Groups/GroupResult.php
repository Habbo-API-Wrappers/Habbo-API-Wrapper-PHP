<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Groups;

/**
 * A Habbo group
 */
class GroupResult
{
    /**
     * @param string $id The ID of the group
     * @param string $name The name of the group
     * @param string $description The description of the group
     * @param GroupType $type The access type of the group
     * @param string $roomId The room ID of the group room
     * @param string $badgeCode The badge code
     * @param string $primaryColour The primary colour of the group
     * @param string $secondaryColour The secondary colour of the group
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public GroupType $type,
        public string $roomId,
        public string $badgeCode,
        public string $primaryColour,
        public string $secondaryColour
    ) {}

    /**
     * Parse a received array to a GroupResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed GroupResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'],
            type: GroupType::fromString($data['type']),
            roomId: $data['roomId'],
            badgeCode: $data['badgeCode'],
            primaryColour: $data['primaryColour'],
            secondaryColour: $data['secondaryColour']
        );
    }
}