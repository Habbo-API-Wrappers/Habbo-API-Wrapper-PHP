<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables\BatchBuilder;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\BatchRequest\BatchResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Http\Transporter;
use Wiredspast\HabboApiWrapperPhp\Param\FurniTargetKind;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\AbstractVariablesResource;
use Wiredspast\HabboApiWrapperPhp\Util\FurniIdSanitiser;

/**
 * A request builder to build a batch request for a furni variable
 */
class FurniVarBatchRequestBuilder extends AbstractVariablesResource
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
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     *
     * @return $this The batch request builder
     */
    public function getVariable(string $opId, FurniTargetKind $targetKind, int $furniId): self
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $this->requests[] = [
            'op_id' => $opId,
            'method' => 'GET',
            'path' => $targetKind->key() . '/' . $furniId
        ];
        return $this;
    }

    /**
     * Assign a variable to a furni
     *
     * @param string $opId The self-defined operation ID, use this same ID to find the response to this operation
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     * @param int $value The value to assign to the variable (defaults to -1)
     *
     * @return $this The batch request builder
     */
    public function giveVariable(string $opId, FurniTargetKind $targetKind, int $furniId, int $value = -1): self
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $this->requests[] = [
            'op_id' => $opId,
            'method' => 'PUT',
            'path' => $targetKind->key() . '/' . $furniId,
            'body' => [
                'value' => $value
            ]
        ];
        return $this;
    }

    /**
     * Change the value of a variable assigned to a furni
     *
     * @param string $opId The self-defined operation ID, use this same ID to find the response to this operation
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     * @param int $value The value to assign to the variable
     *
     * @return $this The batch request builder
     */
    public function changeVariable(string $opId, FurniTargetKind $targetKind, int $furniId, int $value): self
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $this->requests[] = [
            'op_id' => $opId,
            'method' => 'PATCH',
            'path' => $targetKind->key() . '/' . $furniId,
            'body' => [
                'value' => $value
            ]
        ];
        return $this;
    }

    /**
     * Remove a variable assigned to a furni
     *
     * @param string $opId The self-defined operation ID, use this same ID to find the response to this operation
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     *
     * @return $this The batch request builder
     */
    public function removeVariable(string $opId, FurniTargetKind $targetKind, int $furniId): self
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $this->requests[] = [
            'op_id' => $opId,
            'method' => 'DELETE',
            'path' => $targetKind->key() . '/' . $furniId
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
            "/api/public/rooms/$this->roomId/variables/furni/$this->varName/batch",
            [ 'requests' => $this->requests ]
        );
        return BatchResult::fromArray($data);
    }
}