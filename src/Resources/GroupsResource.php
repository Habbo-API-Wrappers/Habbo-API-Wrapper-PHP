<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Groups\GroupMembersResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Groups\GroupResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;

/**
 * Allows access to the endpoints for groups
 */
class GroupsResource extends AbstractResource
{
    /**
     * Retrieves detailed information about a specific group identified by its unique ID.
     *
     * @param string $groupId The unique ID of the group to retrieve.
     *
     * @return GroupResult A detailed representation of the group.
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function byId(string $groupId): GroupResult
    {
        $data = $this->transporter->get("/api/public/groups/$groupId");
        return GroupResult::fromArray($data);
    }

    /**
     * Retrieves a list of members for a specified group, including details.
     *
     * @param string $groupId The unique ID of the group whose members are to be retrieved.
     *
     * @return GroupMembersResult A list of members in the specified group.
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function membersById(string $groupId): GroupMembersResult
    {
        $data = $this->transporter->get("/api/public/groups/$groupId/members");
        return GroupMembersResult::fromArray($data);
    }
}