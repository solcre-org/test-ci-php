<?php

namespace BambooPayment\Core;

use BambooPayment\Util\CaseInsensitiveArray;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use function json_decode;
use const JSON_THROW_ON_ERROR;

/**
 * Class ApiResponse.
 */
class ApiResponse
{
    /**
     * @var null|array|CaseInsensitiveArray
     */
    public $headers;

    /**
     * @var null|array
     */
    public $json;

    /**
     * @var int
     */
    public int $code;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->code = $response->getStatusCode();
        $this->headers = $response->getHeaders();

        try {
            $json = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            $json = null;
            unset($exception);
        }

        $this->json = $json;
    }
}
