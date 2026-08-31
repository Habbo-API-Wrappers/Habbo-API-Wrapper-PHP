<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables;

use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;

/**
 * A list of variables assigned to a user, pet or bot
 */
class UserVariableProfileResult
{
    /**
     * @param VariableResult[] $variables The list of variables assigned to the user, pet or bot
     * @param UserHolder|null $user The user data (if the requested entity is a user, otherwise null)
     * @param PetHolder|null $pet The pet data (if the requested entity is a pet, otherwise null)
     * @param BotHolder|null $bot The bot data (if the requested entity is a bot, otherwise null)
     */
    public function __construct(
        public array $variables,
        public ?UserHolder $user,
        public ?PetHolder $pet,
        public ?BotHolder $bot,
    ) {}

    /**
     * Parse a received array to a UserVariableProfileResult instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserVariableProfileResult instance
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
            user: isset($data['user']) ? UserHolder::fromArray($data['user']) : null,
            pet: isset($data['pet']) ? PetHolder::fromArray($data['pet']) : null,
            bot: isset($data['bot']) ? BotHolder::fromArray($data['bot']) : null
        );
    }
}