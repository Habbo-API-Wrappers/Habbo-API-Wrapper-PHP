<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\BatchRequest;

/**
 * An error that occurred in a batch request
 */
class BatchError
{
    /**
     * @param string $code The code of the error
     * @param string $message The message of the error
     */
    public function __construct(
        public string $code,
        public string $message
    ) {}

    /**
     * Parse a received array to a BatchError instance
     *
     * @param array $data The received array
     *
     * @return self The parsed BatchError instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            message: $data['message']
        );
    }
}