<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Badges;

/**
 * A Habbo badge
 */
class Badge
{
    /**
     * @param string $code The code of the badge
     * @param string $name The name of the badge
     * @param string $description The description of the badge
     */
    public function __construct(
        public string $code,
        public string $name,
        public string $description
    ) {}

    /**
     * Parse a received array to a Badge instance
     *
     * @param array $data The received array
     *
     * @return self The parsed Badge instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            name: $data['name'],
            description: $data['description']
        );
    }
}