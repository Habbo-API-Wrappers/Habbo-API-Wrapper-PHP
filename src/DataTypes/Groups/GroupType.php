<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Groups;

/**
 * The access type of the group
 */
enum GroupType
{
    /**
     * The group is open, anyone can join
     */
    case Normal;
    /**
     * The group is locked, users can request to join, admins can accept new members
     */
    case Exclusive;
    /**
     * The group is locked, nobody can join
     */
    case Closed;

    /**
     * Parse a received string to a GroupType instance
     *
     * @param string $type The received string
     *
     * @return self The parsed GroupType instance
     */
    public static function fromString(string $type): self
    {
        return match($type) {
            'EXCLUSIVE' => self::Exclusive,
            'CLOSED' => self::Closed,
            default => self::Normal
        };
    }

}