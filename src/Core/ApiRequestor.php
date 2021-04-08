<?php

namespace BambooPayment\Core;

use BambooPayment\Exception\ApiErrorException;
use BambooPayment\Exception\AuthenticationException;
use BambooPayment\HttpClient\HttpClient;
use Psr\Http\Message\ResponseInterface;
use function array_merge;

/**
 * Class ApiRequestor.
 */
class ApiRequestor
{
    /**
     * @var null|string
     */
    private ?string $apiKey;

    /**
     * @var string
     */
    private ?string $apiBase;

    /**
     * @var HttpClient
     */
    private static $_httpClient;

    /**
     * ApiRequestor constructor.
     *
     * @param null|string $apiKey
     * @param null|string $apiBase
     */
    public function __construct($apiKey = null, $apiBase = null)
    {
        $this->apiKey = $apiKey;
        $this->apiBase = $apiBase;
    }


    /**
     * @param string $method
     * @param string $url
     * @param null|array $params
     * @param null|array $headers
     *
     * @return array tuple containing (ApiReponse, API key)
     * @throws ApiErrorException
     * @throws AuthenticationException
     */
    public function request(string $method, string $url, $params = null, $headers = null): array
    {
        $params = $params ?: [];
        $headers = $headers ?: [];
        $response = $this->makeRequest($method, $url, $params, $headers);
        $apiResponse = new ApiResponse($response);
        //TODO MANEJAR ERRORES
        $json = $this->interpretResponse($apiResponse);
        return $json;
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
     * @param string $url
     * @param array $params
     * @param array $headers
     *
     * @return ResponseInterface
     * @throws AuthenticationException
     */
    private function makeRequest(string $method, string $url, array $params, array $headers): ResponseInterface
    {
        $myApiKey = $this->apiKey;

        if (! $myApiKey) {
            $msg = 'No API key provided.  (HINT: set your API key using '
                . '"BambooPayment::setApiKey(<API-KEY>)".  You can generate API keys from '
                . 'the BambooPayment web interface.  See https://stripe.com/api for '
                . 'details, or email support@stripe.com if you have any questions.';

            throw new AuthenticationException($msg);
        }

        $absUrl = $this->apiBase . $url;
        $defaultHeaders = $this->defaultHeaders($myApiKey);

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
     * @return array
     */
    private function interpretResponse(ApiResponse $apiResponse): array
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
        if (! self::$_httpClient) {
            self::$_httpClient = HttpClient::instance();
        }

        return self::$_httpClient;
    }
}
