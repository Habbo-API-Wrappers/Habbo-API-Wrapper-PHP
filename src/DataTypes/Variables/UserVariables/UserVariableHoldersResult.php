<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables;

/**
 * A page of user variable holders
 */
class UserVariableHoldersResult
{
    /**
     * @param array $items The user variable holders
     * @param int $page The current page
     * @param int $size The size of the page
     */
    public function __construct(
        public array $items,
        public int $page,
        public int $size
    ) {}

    /**
     * Parse a received array to a UserVariableHoldersResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserVariableHoldersResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            items: array_map(
                function ($item) {
                    return UserVariableHolder::fromArray($item);
                },
                $data['items']
            ),
            page: $data['page'],
            size: $data['size']
        );
    }
}