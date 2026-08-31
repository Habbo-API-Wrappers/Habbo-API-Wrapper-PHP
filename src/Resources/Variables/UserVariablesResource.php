<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\HolderCountResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables\UserVariableHoldersResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\UserVariables\UserVariableProfileResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Param\OrderBy;
use Wiredspast\HabboApiWrapperPhp\Param\OrderDir;
use Wiredspast\HabboApiWrapperPhp\Param\UserTargetKind;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\BatchBuilder\UserVarBatchRequestBuilder;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\ProfileBuilder\UserProfileRequestBuilder;

/**
 * Allows access to the endpoints for user variables
 */
class UserVariablesResource extends AbstractVariablesResource
{
    /**
     * Read a single user variable assignment
     *
     * @param string $variableName The name of the variable
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param int $entityId The ID of the user, pet or bot
     *
     * @return VariableResult The variable's current value and the latest creation and update times
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getVariable(string $variableName, UserTargetKind $targetKind, int $entityId): VariableResult
    {
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables/user/$variableName/{$targetKind->key()}/$entityId"
        );
        return VariableResult::fromArray($data);
    }

    /**
     * Assign a variable to a user, pet or bot
     *
     * This method works similar to `WIRED Effect: Give Variable` with the `Override existing variable` checkbox enabled.
     *
     * @param string $variableName The name of the variable
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param int $entityId The ID of the user, pet or bot
     * @param int $value (Optional) The value you want to assign to the variable
     *
     * @return VariableResult The variable's current value and the latest creation and update times
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function giveVariable(string $variableName, UserTargetKind $targetKind, int $entityId, int $value = -1): VariableResult
    {
        $data = $this->transporter->put(
            "/api/public/rooms/$this->roomId/variables/user/$variableName/{$targetKind->key()}/$entityId",
            [
                'value' => $value
            ]
        );
        return VariableResult::fromArray($data);
    }

    /**
     * Change the value of an existing user variable assignment
     *
     * This method works similar to the `assign` option in `WIRED Effect: Change Variable Value`.
     *
     * @param string $variableName The name of the variable
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param int $entityId The ID of the user, pet or bot
     * @param int $value The value you want to assign to the variable
     *
     * @return VariableResult The variable's current value and the latest creation and update times
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function changeVariable(string $variableName, UserTargetKind $targetKind, int $entityId, int $value): VariableResult
    {
        $data = $this->transporter->put(
            "/api/public/rooms/$this->roomId/variables/user/$variableName/{$targetKind->key()}/$entityId",
            [
                'value' => $value
            ]
        );
        return VariableResult::fromArray($data);
    }

    /**
     * Remove the variable from the user, pet or bot
     *
     * This method works similar to `WIRED Effect: Remove Variable`.
     *
     * @param string $variableName The name of the variable
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param int $entityId The ID of the user, pet or bot
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function removeVariable(string $variableName, UserTargetKind $targetKind, int $entityId): void
    {
        $this->transporter->delete(
            "/api/public/rooms/$this->roomId/variables/user/$variableName/{$targetKind->key()}/$entityId",
        );
    }

    /**
     * List all users, pets or bots that hold the variable and their assigned values
     *
     * @param string $variableName The name of the variable
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param OrderBy $orderBy (optional) Defines what value the response will be ordered by (default = `OrderBy::CreationTime`)
     * @param OrderDir $orderDir (optional) Defines whether the response is in ascending or descending order (default = `OrderDir::Ascending`)
     * @param int $page (optional) The page you want to request (default = `1`)
     * @param int $pageSize (optional) The size of the page (default = `50`)
     *
     * @return UserVariableHoldersResult A list of variable holders
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function listHolders(
        string $variableName,
        UserTargetKind $targetKind,
        OrderBy $orderBy = OrderBy::CreationTime,
        OrderDir $orderDir = OrderDir::Ascending,
        int $page = 1,
        int $pageSize = 50
    ): UserVariableHoldersResult {
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables/user/$variableName/{$targetKind->key()}",
            [
                'order_by' => $orderBy->key(),
                'order_dir' => $orderDir->key(),
                'page' => $page,
                'size' => $pageSize
            ]
        );
        return UserVariableHoldersResult::fromArray($data);
    }

    /**
     * Get the amount of users, pets or bots that hold the variable
     *
     * @param string $variableName The name of the variable
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     *
     * @return HolderCountResult The amount of users, pets or bots that hold the variable
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function countHolders(string $variableName, UserTargetKind $targetKind): HolderCountResult
    {
        $data = $this->transporter->get("/api/public/rooms/$this->roomId/variables/user/$variableName/{$targetKind->key()}/count");
        return HolderCountResult::fromArray($data);
    }

    /**
     * Creates a batch request builder, allowing you to give, change or remove the variable to/from multiple users, pets and bots
     *
     * @param string $variableName The name of the variable
     *
     * @return UserVarBatchRequestBuilder A batch request builder
     */
    public function buildBatchRequest(string $variableName): UserVarBatchRequestBuilder
    {
        return new UserVarBatchRequestBuilder($variableName, $this->roomId, $this->transporter);
    }

    /**
     * List all variables assigned to the user
     *
     * @param string $username The username of the user
     *
     * @return UserVariableProfileResult The user's variable profile, including all variables assigned to them
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getProfileByUsername(string $username): UserVariableProfileResult
    {
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables_profile/user/users",
            [
                'name' => $username
            ]
        );
        return UserVariableProfileResult::fromArray($data);
    }

    /**
     * List all variables assigned to the user
     *
     * @param string $uniqueId The unique ID of the user
     *
     * @return UserVariableProfileResult The user's variable profile, including all variables assigned to them
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getProfileByUniqueId(string $uniqueId): UserVariableProfileResult
    {
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables_profile/user/users",
            [
                'unique_id' => $uniqueId
            ]
        );
        return UserVariableProfileResult::fromArray($data);
    }

    /**
     * List all variables assigned to the user, pet or bot
     *
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param int $entityId The ID of the user, pet or bot
     *
     * @return UserVariableProfileResult The entity's variable profile, including all variables assigned to them
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getProfile(UserTargetKind $targetKind, int $entityId): UserVariableProfileResult
    {
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables_profile/user/{$targetKind->key()}/$entityId"
        );
        return UserVariableProfileResult::fromArray($data);
    }

    /**
     * Remove all variables assigned to the user, pet or bot
     *
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param int $entityId The ID of the user, pet or bot
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function removeProfile(UserTargetKind $targetKind, int $entityId): void
    {
        $this->transporter->delete(
            "/api/public/rooms/$this->roomId/variables_profile/user/{$targetKind->key()}/$entityId"
        );
    }

    /**
     * Change variables assigned to the user, pet or bot
     *
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param int $entityId The ID of the user, pet or bot
     * @param array<string, int | null> $variables The new values for the variables, use the variable name as the key, assigning null removes the variable
     *
     * @return UserVariableProfileResult The entity's updated variable profile, including all variables assigned to them
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function changeProfile(UserTargetKind $targetKind, int $entityId, array $variables): UserVariableProfileResult
    {
        $data = $this->transporter->patch(
            "/api/public/rooms/$this->roomId/variables_profile/user/{$targetKind->key()}/{$entityId}",
            [
                'variables' => $variables
            ]
        );
        return UserVariableProfileResult::fromArray($data);
    }

    /**
     * Create a profile request builder
     *
     * @param UserTargetKind $targetKind The target kind (users / pets / bots)
     * @param int $entityId The ID of the user, pet or bot
     *
     * @return UserProfileRequestBuilder The profile request builder
     */
    public function buildChangeProfileRequest(UserTargetKind $targetKind, int $entityId): UserProfileRequestBuilder
    {
        return new UserProfileRequestBuilder($targetKind, $entityId, $this->roomId, $this->transporter);
    }
}