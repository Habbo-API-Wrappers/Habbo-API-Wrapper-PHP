<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Rooms;

/**
 * A list of rooms owned by a user
 */
class UserRoomsResult
{
    /**
     * @param Room[] $rooms The list of the rooms owned by the user
     */
    public function __construct(
        public array $rooms
    ) {}

    /**
     * Parse a received array to a UserRoomsResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserRoomsResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            rooms: array_map(
                function ($room) {
                    return Room::fromArray($room);
                },
                $data
            )
        );
    }
}