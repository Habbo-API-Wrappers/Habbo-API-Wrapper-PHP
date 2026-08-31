<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables\ProfileBuilder;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Variables\GlobalVariables\GlobalVariableProfileResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Http\Transporter;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\AbstractVariablesResource;

/**
 * A global variable profile request builder, allowing you to change multiple global variables at once
 */
class GlobalProfileRequestBuilder extends AbstractVariablesResource
{
    /**
     * @var array<string, int> $variables
     */
    private array $variables = [];

    /**
     * Create a global variable profile request builder
     *
     * @param int $roomId The ID of the room
     * @param Transporter $transporter The HTTP transporter
     */
    public function __construct(int $roomId, Transporter $transporter)
    {
        parent::__construct($roomId, $transporter);
    }

    /**
     * Change the value of a variable
     *
     * @param string $variableName The name of the variable
     * @param int $value The value you want to assign to the variable
     *
     * @return $this
     */
    public function changeVariable(string $variableName, int $value): self
    {
        $this->variables[$variableName] = $value;
        return $this;
    }

    /**
     * Execute the built request
     *
     * @return GlobalVariableProfileResult The updated global variable profile, including all global variables
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function executeRequest(): GlobalVariableProfileResult
    {
        $data = $this->transporter->patch(
            "/api/public/rooms/$this->roomId/variables_profile/global",
            [
                'variables' => $this->variables,
            ]
        );
        return GlobalVariableProfileResult::fromArray($data);
    }
}