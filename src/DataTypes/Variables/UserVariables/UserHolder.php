<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables;

/**
 * A user holder of a variable
 */
class UserHolder
{
    /**
     * @param string $uniqueId The UUID of the user
     * @param string $name The name of the user
     * @param int $id The ID of the user
     */
    public function __construct(
        public string $uniqueId,
        public string $name,
        public int $id
    ) {}

    /**
     * Parse a received array to a UserHolder instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserHolder instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            uniqueId: $data['unique_id'],
            name: $data['name'],
            id: $data['id']
        );
    }
}