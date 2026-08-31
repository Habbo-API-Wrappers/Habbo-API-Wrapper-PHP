<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Lists\HotLooks;

/**
 * A hot look
 */
class HotLook
{
    /**
     * @param string $gender The gender of the outfit
     * @param string $figure The figure string of the outfit
     * @param string $hash The hash of the outfit
     */
    public function __construct(
        public string $gender,
        public string $figure,
        public string $hash
    ) {}

    /**
     * Parse a received array to a HotLook instance
     *
     * @param array $data The received array
     *
     * @return self The parsed HotLook instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            gender: $data['GENDER'],
            figure: $data['FIGURE'],
            hash: $data['HASH']
        );
    }
}