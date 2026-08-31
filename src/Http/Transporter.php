<?php

namespace Wiredspast\HabboApiWrapperPhp\Http;

use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;
use Wiredspast\HabboApiWrapperPhp\Util\XmlCleaner;

/**
 * The HTTP transport used by the wrapper
 */
class Transporter
{
    /**
     * @var string The base URL used
     */
    private readonly string $baseURL;

    /**
     * @param string $baseURL The base URL used
     * @param ClientInterface $httpClient The HTTP client used to communicate with the API
     * @param RequestFactoryInterface $requestFactory The request factory used to build requests
     * @param StreamFactoryInterface $streamFactory The stream factory used to build request bodies
     * @param array<string, string> $additionalHeaders Additional headers attached to all requests
     */
    public function __construct(
        string $baseURL,
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly array $additionalHeaders = []
    ) {
        $this->baseURL = rtrim($baseURL, '/');
    }

    /**
     * Create a cloned instance of the transporter extended with the given new headers
     *
     * @param array $newAdditionalHeaders The headers to add to the cloned instance
     *
     * @return self A new cloned instance of the transporter
     */
    public function extendWithHeaders(array $newAdditionalHeaders): self
    {
        return new self(
            $this->baseURL,
            $this->httpClient,
            $this->requestFactory,
            $this->streamFactory,
            array_merge($this->additionalHeaders, $newAdditionalHeaders)
        );
    }

    /**
     * Perform a GET request and parse the response as a JSON body
     *
     * @param string $path The path of the request
     * @param string[] $query The query parameters of the request
     *
     * @return array The parsed JSON response
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function get(string $path, array $query = []): array
    {
        $request = $this->buildRequest("GET", $path, [], $query);
        return $this->handleJsonRequest($request);
    }

    /**
     * Perform a GET request and parse the response as an XML body
     *
     * @param string $path The path of the request
     * @param string[] $query The query parameters of the request
     *
     * @return array The parsed XML response
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function getXML(string $path, array $query = []): array
    {
        $request = $this->buildRequest("GET", $path, [], $query, 'application/xml');
        return $this->handleXmlRequest($request);
    }

    /**
     * Perform a POST request and parse the response as a JSON body
     *
     * @param string $path The path of the request
     * @param array $requestBody The body of the request
     * @param string[] $query The query parameters of the request
     *
     * @return array The parsed JSON response
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function post(string $path, array $requestBody, array $query = []): array
    {
        $request = $this->buildRequest("POST", $path, $requestBody, $query);
        return $this->handleJsonRequest($request);
    }

    /**
     * Perform a PUT request and parse the response as a JSON body
     *
     * @param string $path The path of the request
     * @param array $requestBody The body of the request
     * @param string[] $query The query parameters of the request
     *
     * @return array The parsed JSON response
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function put(string $path, array $requestBody, array $query = []): array
    {
        $request = $this->buildRequest("PUT", $path, $requestBody, $query);
        return $this->handleJsonRequest($request);
    }

    /**
     * Perform a PATCH request and parse the response as a JSON body
     *
     * @param string $path The path of the request
     * @param array $requestBody The body of the request
     * @param string[] $query The query parameters of the request
     *
     * @return array The parsed JSON response
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function patch(string $path, array $requestBody, array $query = []): array
    {
        $request = $this->buildRequest("PATCH", $path, $requestBody, $query);
        return $this->handleJsonRequest($request);
    }

    /**
     * Perform a DELETE request
     *
     * @param string $path The path of the request
     * @param string[] $query The query parameters of the request
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function delete(string $path, array $query=[]): void
    {
        $request = $this->buildRequest("DELETE", $path, [], $query);
        $this->handleRawRequest($request);
    }

    /**
     * @param string $requestMethod The request method
     * @param string $path The path of the request
     * @param array $body
     * @param array $query
     * @param string $acceptType
     * @return MessageInterface|RequestInterface
     * @throws HabboApiException
     */
    private function buildRequest(string $requestMethod, string $path, array $body, array $query, string $acceptType = 'application/json'): RequestInterface | MessageInterface
    {
        $url = $this->baseURL . '/' . ltrim($path, '/');
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        $request = $this->requestFactory
            ->createRequest($requestMethod, $url)
            ->withHeader('Accept', $acceptType)
            ->withHeader('User-Agent', 'HabboApiWrapperPhp/1.0');

        if (!empty($body)) {
            try {
                $jsonBody = json_encode($body, JSON_THROW_ON_ERROR);
                $stream = $this->streamFactory->createStream($jsonBody);
                $request = $request
                    ->withHeader('Content-Type', 'application/json')
                    ->withBody($stream);
            } catch (JsonException $e) {
                throw new HabboApiException(
                    'Failed to encode JSON request body: ' . $e->getMessage(),
                    0,
                    '',
                    $e
                );
            }
        }

        foreach ($this->additionalHeaders as $headerName => $header) {
            $request = $request->withHeader($headerName, $header);
        }

        return $request;
    }

    /**
     * @throws HabboApiException
     * @throws ClientExceptionInterface
     */
    private function handleRawRequest(RequestInterface $request): string
    {
        $response = $this->httpClient->sendRequest($request);
        $body = (string) $response->getBody();

        if ($response->getStatusCode() < 200 || $response->getStatusCode() > 299) {
            throw new HabboApiException(
                'API Request failed with status code ' . $response->getStatusCode() . ": " . $response->getReasonPhrase(),
                $response->getStatusCode(),
                $body
            );
        }

        return $body;
    }

    /**
     * @throws HabboApiException
     * @throws ClientExceptionInterface
     */
    private function handleJsonRequest(RequestInterface $request): array
    {
        $body = $this->handleRawRequest($request);
        $body = empty($body) ? "{}" : $body;

        try {
            return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new HabboApiException(
                'Failed to parse JSON response: ' . $e->getMessage(),
                0,
                $body,
                $e
            );
        }
    }

    /**
     * @throws HabboApiException
     * @throws ClientExceptionInterface
     */
    private function handleXmlRequest(RequestInterface $request): array
    {
        $body = $this->handleRawRequest($request);

        $parser = xml_parser_create();
        if (xml_parse_into_struct($parser, $body, $vals, $index) == 1) {
            return XmlCleaner::cleanXml($vals);
        } else {
            throw new HabboApiException(
                'Failed to parse XML response',
                0,
                $body,
                null
            );
        }
    }
}