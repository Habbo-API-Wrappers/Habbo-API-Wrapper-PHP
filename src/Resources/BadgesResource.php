<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Badges\BadgeOwnersResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;

/**
 * Allows access to the endpoints for badges
 */
class BadgesResource extends AbstractResource
{
    /**
     * Returns the amount of users who own the badge plus localized name/description.
     *
     * @param string $badgeCode Badge code to query.
     *
     * @return BadgeOwnersResult Badge owner count.
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function ownerCount(string $badgeCode): BadgeOwnersResult
    {
        $data = $this->transporter->get("/api/public/badge/owners/$badgeCode");
        return BadgeOwnersResult::fromArray($data);
    }
}