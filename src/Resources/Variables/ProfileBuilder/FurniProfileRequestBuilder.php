<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables\ProfileBuilder;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\FurniVariables\FurniVariableProfileResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Http\Transporter;
use Wiredspast\HabboApiWrapperPhp\Param\FurniTargetKind;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\AbstractVariablesResource;
use Wiredspast\HabboApiWrapperPhp\Util\FurniIdSanitiser;

/**
 * A furni variable profile request builder, allowing you to change multiple variables assigned to a single furni at once
 */
class FurniProfileRequestBuilder extends AbstractVariablesResource
{
    /**
     * @var array<string, int | null> $variables
     */
    private array $variables = [];

    /**
     * Create a furni variable profile request builder
     *
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     * @param int $roomId The ID of the room
     * @param Transporter $transporter The HTTP transporter
     */
    public function __construct(
        private readonly FurniTargetKind $targetKind,
        private readonly int $furniId,
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
     * @return FurniVariableProfileResult The furni's updated variable profile, including all variables assigned to it
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function executeRequest(): FurniVariableProfileResult
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($this->furniId);
        $data = $this->transporter->patch(
            "/api/public/rooms/$this->roomId/variables_profile/furni/{$this->targetKind->key()}/$furniId",
            [
                'variables' => $this->variables,
            ]
        );
        return FurniVariableProfileResult::fromArray($data);
    }
}