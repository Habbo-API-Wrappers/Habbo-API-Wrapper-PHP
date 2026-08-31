<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\FurniVariables;

use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;

/**
 * A list of variables assigned to a furni
 */
class FurniVariableProfileResult
{
    /**
     * @param VariableResult[] $variables The list of variables assigned to the furni
     * @param FurniHolder|null $furni The floor item data (if the requested furni is a floor item, otherwise null)
     * @param FurniHolder|null $furniBc The BC floor item data (if the requested furni is a BC floor item, otherwise null)
     * @param FurniHolder|null $wallItem The wall item data (if the requested furni is a wall item, otherwise null)
     * @param FurniHolder|null $wallItemBc The BC wall item data (if the requested furni is a BC wall item, otherwise null)
     */
    public function __construct(
        public array $variables,
        public ?FurniHolder $furni,
        public ?FurniHolder $furniBc,
        public ?FurniHolder $wallItem,
        public ?FurniHolder $wallItemBc
    ) {}

    /**
     * Parse a received array to a FurniVariableProfileResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed FurniVariableProfileResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            variables: array_map(
                function ($variable) {
                    return VariableResult::fromArray($variable);
                },
                $data['variables']
            ),
            furni: isset($data['furni']) ? FurniHolder::fromArray($data['furni']) : null,
            furniBc: isset($data['furni_bc']) ? FurniHolder::fromArray($data['furni_bc']) : null,
            wallItem: isset($data['wall_item']) ? FurniHolder::fromArray($data['wall_item']) : null,
            wallItemBc: isset($data['wall_item_bc']) ? FurniHolder::fromArray($data['wall_item_bc']) : null
        );
    }
}