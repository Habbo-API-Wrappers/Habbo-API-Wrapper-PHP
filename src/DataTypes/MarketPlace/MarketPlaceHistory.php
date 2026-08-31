<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\MarketPlace;

/**
 * A marketplace history entry
 */
class MarketPlaceHistory
{
    /**
     * @param string $dayOffset How mnay days in the past this instance is from
     * @param string $averagePrice The average price at this time
     * @param string $totalSoldItems The total items sold at this time
     * @param string $totalCreditSum The total amount of credits used to buy this item at this time
     * @param string $totalOpenOffers The total amount of open offers for this item at this time
     */
    public function __construct(
        public string $dayOffset,
        public string $averagePrice,
        public string $totalSoldItems,
        public string $totalCreditSum,
        public string $totalOpenOffers
    ) {}

    /**
     * Parse a received array to a MarketPlaceHistory instance
     *
     * @param array $data The received array
     *
     * @return self The parsed MarketPlaceHistory instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dayOffset: $data['dayOffset'],
            averagePrice: $data['averagePrice'],
            totalSoldItems: $data['totalSoldItems'],
            totalCreditSum: $data['totalCreditSum'],
            totalOpenOffers: $data['totalOpenOffers']
        );
    }
}