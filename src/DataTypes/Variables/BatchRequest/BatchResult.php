<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\BatchRequest;

/**
 * The result of a batch request
 */
class BatchResult
{
    /**
     * @param BatchResultEntry[] $results The individual results for each subrequest
     */
    public function __construct(
        public array $results
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
            results: array_map(
                function ($result) {
                    return BatchResultEntry::fromArray($result);
                },
                $data['results']
            )
        );
    }
}