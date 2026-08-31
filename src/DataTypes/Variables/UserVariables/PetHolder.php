<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables;

/**
 * A pet holder of a variable
 */
class PetHolder
{
    /**
     * @param string $name The name of the pet
     * @param int $id The ID of the pet
     */
    public function __construct(
        public string $name,
        public int $id
    ) {}

    /**
     * Parse a received array to a PetHolder instance
     *
     * @param array $data The received array
     *
     * @return self The parsed PetHolder instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            id: $data['id']
        );
    }
}