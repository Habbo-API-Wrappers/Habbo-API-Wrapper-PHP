<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\BatchRequest;

use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;

/**
 * The result of a batch request entry
 */
class BatchResultEntry
{
    /**
     * @param string $opId The op ID of the request
     * @param int $status The status of the request
     * @param VariableResult|null $body The body of the request (null for DELETE or when an error occurs)
     * @param BatchError|null $error The error if the request failed (null if the request succeeded)
     */
    public function __construct(
        public string $opId,
        public int $status,
        public ?VariableResult $body,
        public ?BatchError $error
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
            opId: $data['op_id'],
            status: $data['status'],
            body: isset($data['body']) ? VariableResult::fromArray($data['body']) : null,
            error: isset($data['error']) ? BatchError::fromArray($data['error']) : null
        );
    }
}