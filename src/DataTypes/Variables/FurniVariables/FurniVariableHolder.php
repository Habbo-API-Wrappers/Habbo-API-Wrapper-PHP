<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\FurniVariables;

use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;

/**
 * A variable assigned to a furni
 */
class FurniVariableHolder
{
    /**
     * @param VariableResult $variable The variable data
     * @param FurniHolder|null $furni The floor item data (if the requested furni is a floor item, otherwise null)
     * @param FurniHolder|null $furniBc The BC floor item data (if the requested furni is a BC floor item, otherwise null)
     * @param FurniHolder|null $wallItem The wall item data (if the requested furni is a wall item, otherwise null)
     * @param FurniHolder|null $wallItemBc The BC wall item data (if the requested furni is a BC wall item, otherwise null)
     */
    public function __construct(
        public VariableResult $variable,
        public ?FurniHolder $furni,
        public ?FurniHolder $furniBc,
        public ?FurniHolder $wallItem,
        public ?FurniHolder $wallItemBc
    ) {}

    /**
     * Parse a received array to a FurniVariableHolder instance
     *
     * @param array $data The received array
     *
     * @return self The parsed FurniVariableHolder instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            variable: VariableResult::fromArray($data['variable']),
            furni: isset($data['furni']) ? FurniHolder::fromArray($data['furni']) : null,
            furniBc: isset($data['furni_bc']) ? FurniHolder::fromArray($data['furni_bc']) : null,
            wallItem: isset($data['wall_item']) ? FurniHolder::fromArray($data['wall_item']) : null,
            wallItemBc: isset($data['wall_item_bc']) ? FurniHolder::fromArray($data['wall_item_bc']) : null
        );
    }
}