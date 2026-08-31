<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\FurniVariables;

/**
 * A page of furni variable holders
 */
class FurniVariableHoldersResult
{
    /**
     * @param array $items The furni variable holders
     * @param int $page The current page
     * @param int $size The size of the page
     */
    public function __construct(
        public array $items,
        public int $page,
        public int $size
    ) {}

    /**
     * Parse a received array to a FurniVariableHoldersResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed FurniVariableHoldersResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            items: array_map(
                function ($item) {
                    return FurniVariableHolder::fromArray($item);
                },
                $data['items']
            ),
            page: $data['page'],
            size: $data['size']
        );
    }
}