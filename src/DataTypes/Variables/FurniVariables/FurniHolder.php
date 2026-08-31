<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\FurniVariables;

/**
 * A furni holder of a variable
 */
class FurniHolder
{
    /**
     * @param int $id The ID of the furni
     */
    public function __construct(
        public int $id
    ) {}

    /**
     * Parse a received array to a FurniHolder instance
     *
     * @param array $data The received array
     *
     * @return self The parsed FurniHolder instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id']
        );
    }
}