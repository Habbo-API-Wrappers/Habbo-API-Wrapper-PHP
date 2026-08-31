<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\GlobalVariables;

use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;

class GlobalVariableProfileResult
{
    /**
     * @param VariableResult[] $variables The list of permanent global variables in the room
     */
    public function __construct(
        public array $variables
    ) {}

    /**
     * Parse a received array to a GlobalVariableProfileResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed GlobalVariableProfileResult instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            variables: array_map(
                function ($variable) {
                    return VariableResult::fromArray($variable);
                },
                $data['variables']
            )
        );
    }
}