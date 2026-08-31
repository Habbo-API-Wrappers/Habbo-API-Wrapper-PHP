<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables\ProfileBuilder;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables\UserVariableProfileResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Http\Transporter;
use Wiredspast\HabboApiWrapperPhp\Param\UserTargetKind;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\AbstractVariablesResource;

/**
 * A user variable profile request builder, allowing you to change multiple variables assigned to a single user, pet or bot at once
 */
class UserProfileRequestBuilder extends AbstractVariablesResource
{
    /**
     * @var array<string, int | null> $variables
     */
    private array $variables = [];

    /**
     * Create a user variable profile request builder
     *
     * @param UserTargetKind $targetKind The target kind (user / pet / bot)
     * @param int $entityId The ID of the user, pet or bot
     * @param int $roomId The ID of the room
     * @param Transporter $transporter The HTTP transporter
     */
    public function __construct(
        private readonly UserTargetKind $targetKind,
        private readonly int $entityId,
        int $roomId,
        Transporter $transporter
    ) {
        parent::__construct($roomId, $transporter);
    }

    /**
     * Change the value of a variable assignment or give a variable assignment
     *
     * @param string $variableName The name of the variable
     * @param int $value The value you want to assign to the variable (defaults to -1)
     *
     * @return $this
     */
    public function changeOrGiveVariable(string $variableName, int $value = -1): self
    {
        $this->variables[$variableName] = $value;
        return $this;
    }

    /**
     * Remove a variable assignment
     *
     * @param string $variableName The name of the variable
     *
     * @return $this
     */
    public function removeVariable(string $variableName): self
    {
        $this->variables[$variableName] = null;
        return $this;
    }

    /**
     * Execute the built request
     *
     * @return UserVariableProfileResult The entity's updated variable profile, including all variables assigned to it
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function executeRequest(): UserVariableProfileResult
    {
        $data = $this->transporter->patch(
            "/api/public/rooms/$this->roomId/variables_profile/user/{$this->targetKind->key()}/$this->entityId",
            [
                'variables' => $this->variables,
            ]
        );
        return UserVariableProfileResult::fromArray($data);
    }
}