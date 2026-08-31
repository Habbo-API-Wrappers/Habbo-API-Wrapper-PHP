<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\FurniVariables\FurniVariableHoldersResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\FurniVariables\FurniVariableProfileResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\HolderCountResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Param\OrderBy;
use Wiredspast\HabboApiWrapperPhp\Param\OrderDir;
use Wiredspast\HabboApiWrapperPhp\Param\FurniTargetKind;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\BatchBuilder\FurniVarBatchRequestBuilder;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\ProfileBuilder\FurniProfileRequestBuilder;
use Wiredspast\HabboApiWrapperPhp\Util\FurniIdSanitiser;

/**
 * Allows access to the endpoints for furni variables
 */
class FurniVariablesResource extends AbstractVariablesResource
{
    /**
     * Read a single furni variable assignment
     *
     * @param string $variableName The name of the variable
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     *
     * @return VariableResult The variable's current value and the latest creation and update times
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getVariable(string $variableName, FurniTargetKind $targetKind, int $furniId): VariableResult
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables/furni/$variableName/{$targetKind->key()}/$furniId"
        );
        return VariableResult::fromArray($data);
    }

    /**
     * Assign a variable to a furni
     *
     * This method works similar to `WIRED Effect: Give Variable` with the `Override existing variable` checkbox enabled.
     *
     * @param string $variableName The name of the variable
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     * @param int $value (Optional) The valu you want to assign to the variable
     *
     * @return VariableResult The variable's current value and the latest creation and update times
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function giveVariable(string $variableName, FurniTargetKind $targetKind, int $furniId, int $value = -1): VariableResult
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $data = $this->transporter->put(
            "/api/public/rooms/$this->roomId/variables/furni/$variableName/{$targetKind->key()}/$furniId",
            [
                'value' => $value
            ]
        );
        return VariableResult::fromArray($data);
    }

    /**
     * Change the value of an existing furni variable assignment
     *
     * This method works similar to the `assign` option in `WIRED Effect: Change Variable Value`.
     *
     * @param string $variableName The name of the variable
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     * @param int $value The valu you want to assign to the variable
     *
     * @return VariableResult The variable's current value and the latest creation and update times
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function changeVariable(string $variableName, FurniTargetKind $targetKind, int $furniId, int $value): VariableResult
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $data = $this->transporter->put(
            "/api/public/rooms/$this->roomId/variables/furni/$variableName/{$targetKind->key()}/$furniId",
            [
                'value' => $value
            ]
        );
        return VariableResult::fromArray($data);
    }

    /**
     * Remove the variable from the furni
     *
     * This method works similar to `WIRED Effect: Remove Variable`.
     *
     * @param string $variableName The name of the variable
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function removeVariable(string $variableName, FurniTargetKind $targetKind, int $furniId): void
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $this->transporter->delete(
            "/api/public/rooms/$this->roomId/variables/furni/$variableName/{$targetKind->key()}/$furniId",
        );
    }

    /**
     * List all furni that hold the variable and their assigned values
     *
     * @param string $variableName The name of the variable
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param OrderBy $orderBy (optional) Defines what value the response will be ordered by (default = `OrderBy::CreationTime`)
     * @param OrderDir $orderDir (optional) Defines whether the response is in ascending or descending order (default = `OrderDir::Ascending`)
     * @param int $page (optional) The page you want to request (default = `1`)
     * @param int $pageSize (optional) The size of the page (default = `50`)
     *
     * @return FurniVariableHoldersResult A list of variable holders
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function listHolders(
        string $variableName,
        FurniTargetKind $targetKind,
        OrderBy $orderBy = OrderBy::CreationTime,
        OrderDir $orderDir = OrderDir::Ascending,
        int $page = 1,
        int $pageSize = 50
    ): FurniVariableHoldersResult {
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables/furni/$variableName/{$targetKind->key()}",
            [
                'order_by' => $orderBy->key(),
                'order_dir' => $orderDir->key(),
                'page' => $page,
                'size' => $pageSize
            ]
        );
        return FurniVariableHoldersResult::fromArray($data);
    }

    /**
     * Get the amount of furni that hold the variable
     *
     * @param string $variableName The name of the variable
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     *
     * @return HolderCountResult The amount of furni that hold the variable
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function countHolders(string $variableName, FurniTargetKind $targetKind): HolderCountResult
    {
        $data = $this->transporter->get("/api/public/rooms/$this->roomId/variables/furni/$variableName/{$targetKind->key()}/count");
        return HolderCountResult::fromArray($data);
    }

    /**
     * Creates a batch request builder, allowing you to give, change or remove the variable to/from multiple furni
     *
     * @param string $variableName The name of the variable
     *
     * @return FurniVarBatchRequestBuilder A batch request builder
     */
    public function buildBatchRequest(string $variableName): FurniVarBatchRequestBuilder
    {
        return new FurniVarBatchRequestBuilder($variableName, $this->roomId, $this->transporter);
    }

    /**
     * List all variables assigned to the furni
     *
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     *
     * @return FurniVariableProfileResult The furni's variable profile, including all variables assigned to it
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getProfile(FurniTargetKind $targetKind, int $furniId): FurniVariableProfileResult
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables_profile/furni/{$targetKind->key()}/$furniId"
        );
        return FurniVariableProfileResult::fromArray($data);
    }

    /**
     * Change variables assigned to the user, pet or bot
     *
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     * @param array<string, int | null> $variables The new values for the variables, use the variable name as the key, assigning null removes the variable
     *
     * @return FurniVariableProfileResult The furni's updated variable profile, including all variables assigned to it
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function changeProfile(FurniTargetKind $targetKind, int $furniId, array $variables): FurniVariableProfileResult
    {
        $furniId = FurniIdSanitiser::sanitiseFurniId($furniId);
        $data = $this->transporter->patch(
            "/api/public/rooms/$this->roomId/variables_profile/furni/{$targetKind->key()}/$furniId",
            [
                'variables' => $variables
            ]
        );
        return FurniVariableProfileResult::fromArray($data);
    }

    /**
     * Create a profile request builder
     *
     * @param FurniTargetKind $targetKind The target kind (furni / wall item / BC furni / BC wall item)
     * @param int $furniId The ID of the furni
     *
     * @return FurniProfileRequestBuilder The profile request builder
     */
    public function buildChangeProfileRequest(FurniTargetKind $targetKind, int $furniId): FurniProfileRequestBuilder
    {
        return new FurniProfileRequestBuilder($targetKind, $furniId, $this->roomId, $this->transporter);
    }
}