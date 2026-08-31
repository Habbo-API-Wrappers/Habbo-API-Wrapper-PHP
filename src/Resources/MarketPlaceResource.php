<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\MarketPlace\MarketPlaceStatsBatchResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;

/**
 * Allows access to the endpoints for the marketplace
 */
class MarketPlaceResource extends AbstractResource
{
    /**
     * Provides statistical data for multiple room and wall items.
     *
     * @param string[] $floorItems The classnames of the floor furni you want to request data on
     * @param string[] $wallItems The classnames of the wall furni you want to request data on
     *
     * @return MarketPlaceStatsBatchResult A set of properties for the given items.
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function statsBatch(array $floorItems, array $wallItems): MarketPlaceStatsBatchResult
    {
        $body = [
            'roomItems' => array_map(
                function ($item) {
                    return [
                        'item' => $item
                    ];
                },
                $floorItems
            ),
            'wallItems' => array_map(
                function ($item) {
                    return [
                        'item' => $item
                    ];
                },
                $wallItems
            )
        ];
        $data = $this->transporter->post("/api/public/marketplace/stats/batch", $body);
        return MarketPlaceStatsBatchResult::fromArray($data);
    }
}