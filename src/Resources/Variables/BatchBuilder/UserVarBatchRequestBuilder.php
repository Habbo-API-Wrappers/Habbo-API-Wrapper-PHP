<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables\BatchBuilder;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\BatchRequest\BatchResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Http\Transporter;
use Wiredspast\HabboApiWrapperPhp\Param\UserTargetKind;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\AbstractVariablesResource;

/**
 * A request builder to build a batch request for a user variable
 */
class UserVarBatchRequestBuilder extends AbstractVariablesResource
{
    /**
     * @var array<string, int | null> $requests The values that will be updated
     */
    private array $requests = [];

    /**
     * @param string $varName The variable name
     * @param int $roomId The ID of the room
     * @param Transporter $transporter The HTTP transporter
     */
    public function __construct(
        private readonly string $varName,
        int $roomId,
        Transporter $transporter
    ) {
        parent::__construct($roomId, $transporter);
    }

    /**
     * Get the value of a variable
     *
     * @param string $opId The self-defined operation ID, use this same ID to find the response to this operation
     * @param UserTargetKind $targetKind The target kind (user / pet / bot)
     * @param int $entityId The ID of the user, pet or bot
     *
     * @return $this The batch request builder
     */
    public function getVariable(string $opId, UserTargetKind $targetKind, int $entityId): self
    {
        $this->requests[] = [
            'op_id' => $opId,
            'method' => 'GET',
            'path' => $targetKind->key() . '/' . $entityId
        ];
        return $this;
    }

    /**
     * Assign a variable to a user, pet or bot
     *
     * @param string $opId The self-defined operation ID, use this same ID to find the response to this operation
     * @param UserTargetKind $targetKind The target kind (user / pet / bot)
     * @param int $entityId The ID of the user, pet or bot
     * @param int $value The value to assign to the variable (defaults to -1)
     *
     * @return $this The batch request builder
     */
    public function giveVariable(string $opId, UserTargetKind $targetKind, int $entityId, int $value = -1): self
    {
        $this->requests[] = [
            'op_id' => $opId,
            'method' => 'PUT',
            'path' => $targetKind->key() . '/' . $entityId,
            'body' => [
                'value' => $value
            ]
        ];
        return $this;
    }

    /**
     * Change the value of a variable assigned to a user, pet or bot
     *
     * @param string $opId The self-defined operation ID, use this same ID to find the response to this operation
     * @param UserTargetKind $targetKind The target kind (user / pet / bot)
     * @param int $entityId The ID of the user, pet or bot
     * @param int $value The value to assign to the variable
     *
     * @return $this The batch request builder
     */
    public function changeVariable(string $opId, UserTargetKind $targetKind, int $entityId, int $value): self
    {
        $this->requests[] = [
            'op_id' => $opId,
            'method' => 'PATCH',
            'path' => $targetKind->key() . '/' . $entityId,
            'body' => [
                'value' => $value
            ]
        ];
        return $this;
    }

    /**
     * Remove a variable assigned to a user, pet or bot
     *
     * @param string $opId The self-defined operation ID, use this same ID to find the response to this operation
     * @param UserTargetKind $targetKind The target kind (user / pet / bot)
     * @param int $entityId The ID of the user, pet or bot
     *
     * @return $this The batch request builder
     */
    public function removeVariable(string $opId, UserTargetKind $targetKind, int $entityId): self
    {
        $this->requests[] = [
            'op_id' => $opId,
            'method' => 'DELETE',
            'path' => $targetKind->key() . '/' . $entityId
        ];
        return $this;
    }

    /**
     * Execute the built batch request
     *
     * @return BatchResult The result of the batch request
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function executeRequest(): BatchResult
    {
        $data = $this->transporter->post(
            "/api/public/rooms/$this->roomId/variables/user/$this->varName/batch",
            [ 'requests' => $this->requests ]
        );
        return BatchResult::fromArray($data);
    }
}