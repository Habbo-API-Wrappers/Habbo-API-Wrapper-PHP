<?php

namespace Wiredspast\HabboApiWrapperPhp\Exceptions;

use Exception;
use Throwable;

/**
 * An exception thrown by the Habbo API or the wrapper
 */
class HabboApiException extends Exception
{
    /**
     * @param string $message The message of the exception
     * @param int $code The exception code
     * @param string|null $responseBody The response body if the API responded
     * @param Throwable|null $previous The previous throwable if the wrapper threw an exception
     */
    public function __construct(
        string $message,
        int $code = 0,
        private readonly ?string $responseBody = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the response body that the API replied with
     *
     * @return string|null The response body that the API replied with
     */
    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }
}