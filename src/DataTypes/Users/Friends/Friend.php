<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Friends;

/**
 * A Habbo friend
 */
class Friend
{
    /**
     * @param string $uniqueId The UUID of the friend
     * @param string $name The name of the friend
     * @param string $motto The motto of the friend
     * @param bool $online Whether the friend is online
     * @param string $figureString The figure string of the friend
     */
    public function __construct(
        public string $uniqueId,
        public string $name,
        public string $motto,
        public bool $online,
        public string $figureString
    ) {}

    /**
     * Parse a received array to a Friend instance
     *
     * @param array $data The received array
     *
     * @return self The parsed Friend instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            uniqueId: $data['uniqueId'],
            name: $data['name'],
            motto: $data['motto'],
            online: $data['online'],
            figureString: $data['figureString']
        );
    }
}