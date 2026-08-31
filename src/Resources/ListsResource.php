<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Lists\HotLooks\HotLooksResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Util\XmlCleaner;

/**
 * Allows access to the endpoints for groups
 */
class ListsResource extends AbstractResource
{
    /**
     * Retrieves a list of popular avatars' "hot looks"
     *
     * @return HotLooksResult A list of hot looks
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function hotLooks(): HotLooksResult
    {
        $data = $this->transporter->getXML('/api/public/lists/hotlooks');
        return HotLooksResult::fromArray($data);
    }
}