<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\MarketPlace;

/**
 * The marketplace data for an item
 */
class MarketPlaceItemData
{
    /**
     * @param string $item The classname of the item
     * @param string $statsDate The date that the statistics were last updated
     * @param MarketPlaceHistory[] $history The sale history of the item
     * @param int $soldItemCount The amount of items sold
     * @param int $creditSum The amount of credits this item was listed for
     * @param int $averagePrice The average price of the item
     * @param int $totalOpenOffers The amount of total open offers of the item
     * @param int $currentOpenOffers The amount of current open offers of the item
     * @param int $currentPrice The current price of the item
     * @param int $historyLimitInDays The limit of the history
     */
    public function __construct(
        public string $item,
        public string $statsDate,
        public array $history,
        public int $soldItemCount,
        public int $creditSum,
        public int $averagePrice,
        public int $totalOpenOffers,
        public int $currentOpenOffers,
        public int $currentPrice,
        public int $historyLimitInDays
    ) {}

    /**
     * Parse a received array to a MarketPlaceItemData instance
     *
     * @param array $data The received array
     *
     * @return self The parsed MarketPlaceItemData instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            item: $data['item'],
            statsDate: $data['statsDate'],
            history: array_map(
                function ($historyData) {
                    return MarketPlaceHistory::fromArray($historyData);
                },
                $data['history']
            ),
            soldItemCount: $data['soldItemCount'],
            creditSum: $data['creditSum'],
            averagePrice: $data['averagePrice'],
            totalOpenOffers: $data['totalOpenOffers'],
            currentOpenOffers: $data['currentOpenOffers'],
            currentPrice: $data['currentPrice'],
            historyLimitInDays: $data['historyLimitInDays']
        );
    }
}