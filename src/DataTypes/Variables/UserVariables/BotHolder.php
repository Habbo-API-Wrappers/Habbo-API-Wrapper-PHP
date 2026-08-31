<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables;

/**
 * A bot holder of a variable
 */
class BotHolder
{
    /**
     * @param string $name The name of the bot
     * @param int $id The ID of the bot
     */
    public function __construct(
        public string $name,
        public int $id
    ) {}

    /**
     * Parse a received array to a BotHolder instance
     *
     * @param array $data The received array
     *
     * @return self The parsed BotHolder instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            id: $data['id']
        );
    }
}