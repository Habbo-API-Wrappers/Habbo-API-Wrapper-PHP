<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\GlobalVariables\GlobalVariableProfileResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\VariableResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\ProfileBuilder\GlobalProfileRequestBuilder;

/**
 * Allows access to the endpoints for global variables
 */
class GlobalVariablesResource extends AbstractVariablesResource
{
    /**
     * Get the value of a variable
     *
     * @param string $varName The name of the variable
     *
     * @return VariableResult The value of the variable and its last edit times
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getVariable(string $varName): VariableResult
    {
        $data = $this->transporter->get("/api/public/rooms/$this->roomId/variables/global/$varName");
        return VariableResult::fromArray($data);
    }

    /**
     * Change the value of a variable
     *
     * @param string $varName The name of the variable
     * @param int $value The value to assign
     *
     * @return VariableResult The updated value of the variable and its last edit times
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function changeVariable(string $varName, int $value): VariableResult
    {
        $data = $this->transporter->patch(
            "/api/public/rooms/$this->roomId/variables/global/$varName",
            [
                'value' => $value
            ]
        );
        return VariableResult::fromArray($data);
    }

    /**
     * List all global variables and their values
     *
     * @return GlobalVariableProfileResult The global variable profile
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getProfile(): GlobalVariableProfileResult
    {
        $data = $this->transporter->get(
            "/api/public/rooms/$this->roomId/variables_profile/global"
        );
        return GlobalVariableProfileResult::fromArray($data);
    }

    /**
     * Change multiple global variable values
     *
     * @param array<string, int> $variables The new values for the variables, use the variable name as the key
     *
     * @return GlobalVariableProfileResult The updated global variable profile
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function changeProfile(array $variables): GlobalVariableProfileResult
    {
        $data = $this->transporter->patch(
            "/api/public/rooms/$this->roomId/variables_profile/global",
            [
                'variables' => $variables,
            ]
        );
        return GlobalVariableProfileResult::fromArray($data);
    }

    /**
     * Create a profile request builder
     *
     * @return GlobalProfileRequestBuilder The profile request builder
     */
    public function buildChangeProfileRequest(): GlobalProfileRequestBuilder
    {
        return new GlobalProfileRequestBuilder($this->roomId, $this->transporter);
    }
}