<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables;

/**
 * The amount of entities that hold a variable
 */
class HolderCountResult
{
    /**
     * @param int $count The amount of entities that hold a variable
     */
    public function __construct(
        public int $count
    ) {}

    /**
     * Parse a received array to a HolderCountResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed HolderCountResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            count: $data['count']
        );
    }
}