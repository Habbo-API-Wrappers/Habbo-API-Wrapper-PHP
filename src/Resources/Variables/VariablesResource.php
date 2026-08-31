<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariablesListResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Http\Transporter;

/**
 * Allows access to the endpoints for variables for a specified room
 */
class VariablesResource extends AbstractVariablesResource
{
    private ?UserVariablesResource $userVariablesResource = null;
    private ?FurniVariablesResource $furniVariablesResource = null;
    private ?GlobalVariablesResource $globalVariablesResource = null;

    /**
     * List the names of all permanent variables in the room
     *
     * @returns A list with all variable names
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function listAll(): VariablesListResult
    {
        $data = $this->transporter->get("/api/public/rooms/$this->roomId/variables");
        return VariablesListResult::fromArray($data);
    }

    /**
     * Delete all variable assignment for the given variables
     *
     * @param string ...$varNames The variable names to remove
     *
     * @return bool Whether the variable assignments have been removed
     */
    public function bulkDelete(string ...$varNames): bool
    {
        try {
            $this->transporter->post(
                "/api/public/rooms/$this->roomId/variables/bulk-delete",
                [
                    "variables" => $varNames
                ]
            );
            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }

    /**
     * Access the endpoints related to user variables
     *
     * @return UserVariablesResource
     */
    public function user(): UserVariablesResource
    {
        return $this->userVariablesResource ??= new UserVariablesResource($this->roomId, $this->transporter);
    }

    /**
     * Access the endpoints related to furni variables
     *
     * @return FurniVariablesResource
     */
    public function furni(): FurniVariablesResource
    {
        return $this->furniVariablesResource ??= new FurniVariablesResource($this->roomId, $this->transporter);
    }

    /**
     * Access the endpoints related to global variables
     *
     * @return GlobalVariablesResource
     */
    public function global(): GlobalVariablesResource
    {
        return $this->globalVariablesResource ??= new GlobalVariablesResource($this->roomId, $this->transporter);
    }
}