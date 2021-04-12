<?php

namespace BambooPayment\Core;

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
     * @var HttpClient
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
     */
    public function __construct(string $method, string $path, array $params, string $apiKey, string $apiBase, array $headers)
    {
        $this->method = $method;
        $this->params = $params;
        $this->headers = $headers;
        $this->apiKey = $apiKey;
        $this->absUrl = $apiBase . $path;
    }

    public function request(): ApiResponse
    {
        $response = $this->makeRequest($this->method, $this->absUrl, $this->params, $this->headers);

        return new ApiResponse($response->getBody(), $response->getStatusCode(), $response->getHeaders());
    }

//    public function handleErrorResponse($rbody, $rcode, $rheaders, $resp)
//    {
//        if (! is_array($resp) || ! isset($resp['error'])) {
//            $msg = "Invalid response object from API: {$rbody} "
//                . "(HTTP response code was {$rcode})";
//
//            throw new UnexpectedValueException($msg);
//        }
//
//        $errorData = $resp['error'];
//
//        $error = null;
//        if (is_string($errorData)) {
//            $error = self::_specificOAuthError($rbody, $rcode, $rheaders, $resp, $errorData);
//        }
//        if (! $error) {
//            $error = self::_specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData);
//        }
//
//        throw $error;
//    }
//    private static function _specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData)
//    {
//        $msg = isset($errorData['message']) ? $errorData['message'] : null;
//        $param = isset($errorData['param']) ? $errorData['param'] : null;
//        $code = isset($errorData['code']) ? $errorData['code'] : null;
//        $type = isset($errorData['type']) ? $errorData['type'] : null;
//        $declineCode = isset($errorData['decline_code']) ? $errorData['decline_code'] : null;
//
//        switch ($rcode) {
//            case 400:
//                // 'rate_limit' code is deprecated, but left here for backwards compatibility
//                // for API versions earlier than 2015-09-08
//                if ('rate_limit' === $code) {
//                    return Exception\RateLimitException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
//                }
//                if ('idempotency_error' === $type) {
//                    return Exception\IdempotencyException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
//                }
//
//            // no break
//            case 404:
//                return Exception\InvalidRequestException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
//
//            case 401:
//                return Exception\AuthenticationException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
//
//            case 402:
//                return Exception\CardException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $declineCode, $param);
//
//            case 403:
//                return Exception\PermissionException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
//
//            case 429:
//                return Exception\RateLimitException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
//
//            default:
//                return Exception\UnknownApiErrorException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
//        }
//    }

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
        $defaultHeaders = $this->defaultHeaders($this->apiKey);
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
     */
    public function interpretResponse(ApiResponse $apiResponse): array
    {
        $rbody = $apiResponse->json;
        $rcode = $apiResponse->code;

//        $jsonError = \json_last_error();
//        if (null === $resp && \JSON_ERROR_NONE !== $jsonError) {
//            $msg = "Invalid response body from API: {$rbody} "
//                . "(HTTP response code was {$rcode}, json_last_error() was {$jsonError})";
//
//            throw new UnexpectedValueException($msg, $rcode);
//        }

//        if ($rcode < 200 || $rcode >= 300) {
//            $this->handleErrorResponse($rbody, $rcode, $apiResponse->headers);
//        }

        return $rbody['Response'];
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
