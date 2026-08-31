<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables;

use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;

/**
 * A variable assigned to a user, pet or furni
 */
class UserVariableHolder
{
    /**
     * @param VariableResult $variable The variable data
     * @param UserHolder|null $user The user data (if the requested entity is a user, otherwise null)
     * @param PetHolder|null $pet The pet data (if the requested entity is a pet, otherwise null)
     * @param BotHolder|null $bot The bot data (if the requested entity is a bot, otherwise null)
     */
    public function __construct(
        public VariableResult $variable,
        public ?UserHolder $user,
        public ?PetHolder $pet,
        public ?BotHolder $bot
    ) {}

    /**
     * Parse a received array to a UserVariableHolder instance
     *
     * @param array $data The received array
     *
     * @return self The parsed UserVariableHolder instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            variable: VariableResult::fromArray($data['variable']),
            user: isset($data['user']) ? UserHolder::fromArray($data['user']) : null,
            pet: isset($data['pet']) ? PetHolder::fromArray($data['pet']) : null,
            bot: isset($data['bot']) ? BotHolder::fromArray($data['bot']) : null
        );
    }
}