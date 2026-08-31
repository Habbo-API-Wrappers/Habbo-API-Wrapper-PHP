<?php

namespace Wiredspast\HabboApiWrapperPhp\Param;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Wiredspast\HabboApiWrapperPhp\HabboPublicAPI;

/**
 * An enum containing the official Habbo hotels
 */
enum Hotel
{
    case BR;
    case COM;
    case DE;
    case ES;
    case FI;
    case FR;
    case IT;
    case NL;
    case S2;
    case TR;

    /**
     * Get the base URL of the hotel
     *
     * @return string The base URL of the hotel (including scheme and trailing slash)
     */
    public function getDomain(): string
    {
        return match($this) {
            Hotel::BR => "https://www.habbo.com.br/",
            Hotel::COM => "https://www.habbo.com/",
            Hotel::DE => "https://www.habbo.de/",
            Hotel::ES => "https://www.habbo.es/",
            Hotel::FI => "https://www.habbo.fi/",
            Hotel::FR => "https://www.habbo.fr/",
            Hotel::IT => "https://www.habbo.it/",
            Hotel::NL => "https://www.habbo.nl/",
            Hotel::S2 => "https://sandbox.habbo.com/",
            Hotel::TR => "https://www.habbo.com.tr/",
        };
    }

    /**
     * Create a new API wrapper for the hotel
     *
     * @param ClientInterface|null $httpClient The PSR-18 HTTP client used to communicate with the API (automatically finds a PSR-18 HTTP client if null)
     * @param RequestFactoryInterface|null $requestFactory The PSR-17 request factory to build the API requests (automatically finds a PSR-17 Request Factory if null)
     * @param StreamFactoryInterface|null $streamFactory The PSR-17 stream factory to build the API request body (automatically finds a PSR-17 Stream Factory if null)
     *
     * @return HabboPublicAPI The API wrapper
     */
    public function getApiWrapper(
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null
    ): HabboPublicAPI {
        return new HabboPublicAPI($this->getDomain(), $httpClient, $requestFactory, $streamFactory);
    }
}
