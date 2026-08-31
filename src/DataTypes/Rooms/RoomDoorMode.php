<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Rooms;

/**
 * The door mode of a room
 */
enum RoomDoorMode
{
    /**
     * The room is open, anyone can enter
     */
    case Open;
    /**
     * The room is locked, users without rights and not in the group have to ring the bell
     */
    case Closed;
    /**
     * The room is locked, users without rights and not in the group have to enter the correct password
     */
    case Password;
    /**
     * The room is locked for users the owner is not friends with
     */
    case Friends;

    /**
     * Parse a received string to a RoomDoorMode instance
     *
     * @param string $s The received string
     *
     * @return self The parsed RoomDoorMode instance
     */
    public static function fromString(string $s): self
    {
        return match ($s) {
            'closed' => self::Closed,
            'password' => self::Password,
            'friends' => self::Friends,
            default => self::Open
        };
    }
}