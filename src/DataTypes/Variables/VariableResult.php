<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables;

/**
 * A variable assignments data
 */
class VariableResult
{
    /**
     * @param int $value The value of the variable
     * @param string $creationTime The creation time of the variable
     * @param string $updateTime The update time of the variable
     */
    public function __construct(
        public int $value,
        public string $creationTime,
        public string $updateTime
    ) {}

    /**
     * Parse a received array to a VariableResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed VariableResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            value: $data['value'],
            creationTime: $data['creation_time'],
            updateTime: $data['update_time']
        );
    }
}