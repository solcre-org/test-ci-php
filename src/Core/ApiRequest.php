<?php

namespace BambooPayment\Core;

use BambooPayment\Exception\ApiErrorException;
use BambooPayment\Exception\AuthenticationException;
use BambooPayment\Exception\ExceptionInterface;
use BambooPayment\Exception\InvalidRequestException;
use BambooPayment\Exception\PermissionException;
use BambooPayment\Exception\UnknownApiErrorException;
use BambooPayment\HttpClient\HttpClient;
use Psr\Http\Message\ResponseInterface;
use function array_merge;

class ApiRequest
{
    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $absUrl;

    /**
     * @var array
     */
    private array $params;
    /**
     * @var array
     */
    private array $headers;

    /**
     * @var string
     */
    private string $apiKey;

    /**
     * @var HttpClient|null
     */
    private static ?HttpClient $_httpClient = null;

    /**
     * ApiRequest constructor.
     *
     * @param string $method
     * @param string $path
     * @param array $params
     * @param string $apiKey
     * @param string $apiBase
     * @param array $headers
     */
    public function __construct(string $method, string $path, array $params, string $apiKey, string $apiBase, array $headers)
    {
        $this->method  = $method;
        $this->params  = $params;
        $this->headers = $headers;
        $this->apiKey  = $apiKey;
        $this->absUrl  = $apiBase . $path;
    }

    public function request(): ApiResponse
    {
        $response = $this->makeRequest($this->method, $this->absUrl, $this->params, $this->headers);

        return new ApiResponse($response->getBody(), $response->getStatusCode(), $response->getHeaders());
    }

    /**
     * @static
     *
     * @param string $apiKey
     *
     * @return array
     */
    private function defaultHeaders(string $apiKey): array
    {
        return [
            'Authorization' => 'Basic ' . $apiKey,
            'Content-Type'  => 'application/json'
        ];
    }

    /**
     * @param string $method
     * @param string $absUrl
     * @param array $params
     * @param array $headers
     *
     * @return ResponseInterface
     */
    private function makeRequest(string $method, string $absUrl, array $params, array $headers): ResponseInterface
    {
        $defaultHeaders  = $this->defaultHeaders($this->apiKey);
        $combinedHeaders = array_merge($defaultHeaders, $headers);

        return $this->httpClient()->request(
            $method,
            $absUrl,
            $combinedHeaders,
            $params
        );
    }

    /**
     * @param ApiResponse $apiResponse
     *
     * @return array
     *
     * @throws ApiErrorException
     * @throws AuthenticationException
     * @throws InvalidRequestException
     * @throws PermissionException
     * @throws UnknownApiErrorException
     */
    public function interpretResponse(ApiResponse $apiResponse): array
    {
        $body = $apiResponse->json;
        $code = $apiResponse->code;

        if ($code < 200 || $code >= 300) {
            $this->handleErrorResponse($body, $code);
        }

        return $body[BambooPaymentClient::ARRAY_RESULT_KEY];
    }

    /**
     * @param array|null $body
     * @param int $code
     *
     * @throws UnknownApiErrorException|ApiErrorException|PermissionException|AuthenticationException|InvalidRequestException
     */
    private function handleErrorResponse(?array $body, int $code): void
    {
        $errorHandler = new ErrorHandler();
        try {
            $errorHandler->handleErrorResponse($body, $code);
        } catch (ExceptionInterface $e) {
            throw $e;
        }
    }

    /**
     * @static
     *
     * @param HttpClient $client
     */
    public static function setHttpClient(HttpClient $client): void
    {
        self::$_httpClient = $client;
    }

    /**
     * @return HttpClient
     */
    private function httpClient(): HttpClient
    {
        if (! self::$_httpClient instanceof HttpClient) {
            self::$_httpClient = HttpClient::instance();
        }

        return self::$_httpClient;
    }
}
