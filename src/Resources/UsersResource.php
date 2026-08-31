<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Badges\UserBadgesResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Friends\UserFriendsResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Groups\UserGroupsResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Rooms\UserRoomsResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\UserProfileResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\UserResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;

/**
 * Allows access to the endpoints for users
 */
class UsersResource extends AbstractResource
{
    /**
     * Retrieve user information by name. Less information is shown for users with limited profile visibility.
     *
     * @param string $name The unique name of the user to retrieve information for
     *
     * @return UserResult The retrieved user information
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function byName(string $name): UserResult
    {
        $data = $this->transporter->get('/api/public/users', ['name' => $name]);
        return UserResult::fromArray($data);
    }

    /**
     * Retrieves detailed public information about a user by their unique ID. Less information is shown for users with limited profile visibility.
     *
     * @param string $uniqueId The unique ID of the user to retrieve information for
     *
     * @return UserResult The retrieved user information
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function byUniqueId(string $uniqueId): UserResult
    {
        $data = $this->transporter->get("/api/public/users/$uniqueId");
        return UserResult::fromArray($data);
    }

    /**
     * Fetches a list of friends for a user identified by their unique ID. The friends list is only returned if user is found and the profile is visible.
     *
     * @param string $uniqueId The unique ID of the user whose friends list is being requested
     *
     * @return UserFriendsResult The retrieved list of friends
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function friends(string $uniqueId): UserFriendsResult
    {
        $data = $this->transporter->get("/api/public/users/$uniqueId/friends");
        return UserFriendsResult::fromArray($data);
    }

    /**
     * Fetches a list of groups that a user is a member of, identified by their unique ID.
     *
     * @param string $uniqueId The unique ID of the user whose groups list is being requested
     *
     * @return UserGroupsResult The retrieved list of groups
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function groups(string $uniqueId): UserGroupsResult
    {
        $data = $this->transporter->get("/api/public/users/$uniqueId/groups");
        return UserGroupsResult::fromArray($data);
    }

    /**
     * Fetches a list of public rooms that a user owns, identified by their unique ID.
     *
     * @param string $uniqueId The unique ID of the user whose rooms list is being requested
     *
     * @return UserRoomsResult The retrieved list of rooms
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function rooms(string $uniqueId): UserRoomsResult
    {
        $data = $this->transporter->get("/api/public/users/$uniqueId/rooms");
        return UserRoomsResult::fromArray($data);
    }

    /**
     * Fetches a list of badges that a user has earned, identified by their unique ID.
     *
     * @param string $uniqueId The unique ID of the user whose badge list is being requested
     *
     * @return UserBadgesResult The retrieved list of badges
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function badges(string $uniqueId): UserBadgesResult
    {
        $data = $this->transporter->get("/api/public/users/$uniqueId/badges");
        return UserBadgesResult::fromArray($data);
    }

    /**
     * Fetches detailed profile information for a user identified by their unique ID.
     *
     * @param string $uniqueId The unique ID of the user whose profile is being requested
     *
     * @return UserProfileResult The retrieved profile
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function profile(string $uniqueId): UserProfileResult
    {
        $data = $this->transporter->get("/api/public/users/$uniqueId/profile");
        return UserProfileResult::fromArray($data);
    }
}