<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables;

/**
 * A list of all permanent variables in the room
 */
class VariablesListResult
{
    /**
     * @param string[] $users The list of permanent user variables in the room
     * @param string[] $furni The list of permanent furni variables in the room
     * @param string[] $global The list of permanent global variables in the room
     */
    public function __construct(
        public array $users,
        public array $furni,
        public array $global
    ) {}

    /**
     * Parse a received array to a VariablesListResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed VariablesListResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            users: $data['users'],
            furni: $data['furni'],
            global: $data['global']
        );
    }
}