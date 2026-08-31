<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users;

use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Badges\Badge;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Friends\Friend;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Groups\Group;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Rooms\Room;

/**
 * A users extended profile
 */
class UserProfileResult
{
    /**
     * @param SelectedBadge[] $selectedBadges
     * @param Group[] $groups
     * @param Badge[] $badges
     * @param Friend[] $friends
     * @param Room[] $rooms
     */
    /**
     * @param UserResult $user The users base profile
     * @param array $groups The users groups
     * @param array $badges The users badges
     * @param array $friends The users friends
     * @param array $rooms The users rooms
     */
    public function __construct(
        public UserResult $user,
        public array $groups,
        public array $badges,
        public array $friends,
        public array $rooms
    ) {}

    /**
     * Parse a received array to a UserProfileResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserProfileResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            user: UserResult::fromArray($data['user']),
            groups: array_map(
                function ($group) {
                    return Group::fromArray($group);
                },
                $data['groups']
            ),
            badges: array_map(
                function ($badge) {
                    return Badge::fromArray($badge);
                },
                $data['badges']
            ),
            friends: array_map(
                function ($friend) {
                    return Friend::fromArray($friend);
                },
                $data['friends']
            ),
            rooms: array_map(
                function ($room) {
                    return Room::fromArray($room);
                },
                $data['rooms']
            )
        );
    }
}