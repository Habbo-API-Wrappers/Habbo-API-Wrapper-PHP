<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Lists\HotLooks;

/**
 * The list of current hot looks
 */
class HotLooksResult
{
    /**
     * @param string $url The requested URL
     * @param HotLook[] $looks The list of hot looks
     */
    public function __construct(
        public string $url,
        public array $looks
    ) {}

    /**
     * Parse a received array to a HotLooksResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed HotLooksResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: $data['HABBOS'][0]['URL'],
            looks: array_map(
                function ($look) {
                    return HotLook::fromArray($look);
                },
                $data['HABBOS'][0]['HABBO']
            )
        );
    }
}