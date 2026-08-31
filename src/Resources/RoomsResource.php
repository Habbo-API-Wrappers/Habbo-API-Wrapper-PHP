<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Rooms\RoomResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;

/**
 * Allows access to the endpoints for rooms
 */
class RoomsResource extends AbstractResource
{
    /**
     * Fetches detailed information about a public room identified by its unique ID. The room details are returned if the room is found.
     *
     * @param int $roomId The ID of the room to retrieve information for.
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function byId(int $roomId): RoomResult
    {
        $data = $this->transporter->get("/api/public/rooms/$roomId");
        return RoomResult::fromArray($data);
    }
}