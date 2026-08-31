<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\MarketPlace;

/**
 * The response of a marketplace batch request
 */
class MarketPlaceStatsBatchResult
{
    /**
     * @param string $status The status of the request
     * @param MarketPlaceItemData[] $roomItemData The requested floor item data
     * @param MarketPlaceItemData[] $wallItemData The requested wall item data
     */
    public function __construct(
        public string $status,
        public array $roomItemData,
        public array $wallItemData
    ) {}

    /**
     * Parse a received array to a MarketPlaceStatsBatchResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed MarketPlaceStatsBatchResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'],
            roomItemData: array_map(
                function ($itemData) {
                    return MarketPlaceItemData::fromArray($itemData);
                },
                $data['roomItemData']
            ),
            wallItemData: array_map(
                function ($itemData) {
                    return MarketPlaceItemData::fromArray($itemData);
                },
                $data['wallItemData']
            )
        );
    }
}